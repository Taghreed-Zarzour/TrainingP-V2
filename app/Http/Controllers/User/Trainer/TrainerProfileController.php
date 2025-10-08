<?php

namespace App\Http\Controllers\User\Trainer;

use App\Enums\SexEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerRequests\profilePhoto;
use App\Http\Requests\TrainerRequests\updateContactInfo;
use App\Http\Requests\TrainerRequests\updateExperiance;
use App\Http\Requests\TrainerRequests\updatePersonalInfo;
use App\Models\Country;
use App\Models\PreviousTraining;
use App\Models\ProvidedService;
use App\Models\Trainer;
use App\Models\User;
use App\Models\UserCv;
use App\Models\WorkField;
use App\Models\WorkSector;
use App\Services\TrainerService;
use App\Models\TrainerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrainerProfileController extends Controller
{
  protected $trainerService;

  public function __construct(TrainerService $trainerService)
  {
    $this->trainerService = $trainerService;
  }

  public function showProfile($userIdentifier = null)
  {
    // الحالة 1: إذا كان الرابط يحتوي على ID فقط (مثال: /show-profile/123)
    if (is_numeric($userIdentifier)) {
      $userId = $userIdentifier;
    }
    // الحالة 2: إذا كان الرابط يحتوي على Slug (مثال: /show-profile/john-doe-123)
    elseif (strpos($userIdentifier, '-') !== false) {
      $userId = (int) substr($userIdentifier, strrpos($userIdentifier, '-') + 1);
    }
    // الحالة 3: إذا لم يتم تمرير أي معرف، استخدم ID المستخدم الحالي
    else {
      $userId = Auth::id();
    }

    $user = User::with('country',)->findOrFail($userId);
    $trainer = Trainer::where('id', $userId)->firstOrFail();
    $sexs = SexEnum::cases();
    $work_sectors = WorkSector::all();
    $provided_services = ProvidedService::all();
    $work_fields = WorkField::all();
    $countries = Country::all();
    $profileCompletion = $this->getProfileCompletion($userId);
    $trainer_providedServices = ProvidedService::whereIn('id', $trainer->provided_services ?? [])->get();

    $trainer_workSectors = WorkSector::whereIn('id', $trainer->work_sectors ?? [])->get();

    $trainer_workFields = WorkField::whereIn('id', $trainer->work_fields ?? [])->get();

    $trainer_mportantTopics = $trainer->important_topics ?? [];

    $international_exp_ids = $trainer->international_exp ?? [];
    $trainer_internationalExperiences = Country::whereIn('id', $international_exp_ids)->get();

    $selected_country = Country::where('phonecode', ltrim($user->phone_code, '+'))->first();

    $ratings = $trainer->ratings;

    // اجمالي تقييم كل متدرب للمدرب
    $averageRatings = [];
    foreach ($ratings as $rating) {
      $trainee_id = $rating->trainee_id;
      if (!isset($averageRatings[$trainee_id])) {
        $average = TrainerRating::where('trainer_id', $trainer->id)
          ->where('trainee_id', $trainee_id)
          ->avg(DB::raw('(clarity + interaction + organization)/3'));
        $averageRatings[$trainee_id] = $average;
      }
    }

    // اجمالي تقييمات المدرب
    $totalSum = TrainerRating::where('trainer_id', $trainer->id)
      ->sum(DB::raw('clarity + interaction + organization'));
    $totalCount = TrainerRating::where('trainer_id', $trainer->id)->count();
    $averageTrainerRating = $totalCount > 0 ? ($totalSum / (3 * $totalCount)) : 0;

    // تدريبات خاصة بالمدرب
    $tariningPrograms = $trainer->trainingPrograms;
    $tariningPrograms->load('trainer', 'sessions');


    return view(
      'user.trainer.show_profile',
      compact(
        'user',
        'trainer',
        'trainer_providedServices',
        'trainer_workSectors',
        'trainer_workFields',
        'countries',
        'work_sectors',
        'provided_services',
        'work_fields',
        'trainer_internationalExperiences',
        'selected_country',
        'profileCompletion',
        'ratings',
        'averageRatings',
        'averageTrainerRating',
        'tariningPrograms',
      )
    );
  }

  protected function getProfileCompletion($trainerId)
  {
    $user = User::find($trainerId);
    $trainer = Trainer::find($trainerId);
    $trainerCv = UserCv::where('user_id', $trainerId)->first();
    $previousTraining = PreviousTraining::where('trainer_id', $trainerId)->first();
    if (!$user || !$trainer) {
      return 0; // Or throw an exception
    }

    // List of important user fields
    $fieldsToCheck = [
      $user->getTranslation('name', 'ar'),
      $user->getTranslation('name', 'en'),
      $user->bio,
      $user->phone_number,
      $user->phone_code,
      $user->city,
      $user->country_id,
      $user->photo,
    ];

    // Trainer fields
    $fieldsToCheck = array_merge($fieldsToCheck, [
      $trainer->getTranslation('last_name', 'ar'),
      $trainer->getTranslation('last_name', 'en'),
      $trainer->sex,
      $trainer->headline,
      $trainer->nationality,
      $trainer->hourly_wage,
      $trainer->currency,
      $trainer->linkedin_url,
      $trainer->website,
      $trainer->important_topics,
      $trainer->work_fields,
      $trainer->provided_services,
      $trainer->work_sectors,
      $trainer->international_exp,
    ]);
    $fieldsToCheck = array_merge($fieldsToCheck, [
      $trainerCv->cv_file ?? null,
    ]);
    $fieldsToCheck = array_merge($fieldsToCheck, [
      $previousTraining->video_link ?? null,
      $previousTraining->training_title ?? null,
      $previousTraining->description ?? null,
    ]);

    $total = count($fieldsToCheck);
    $filled = collect($fieldsToCheck)->filter(function ($value) {
      return !is_null($value) && $value !== '' && $value !== [] && $value !== 0;
    })->count();


    return intval(($filled / $total) * 100);
  }


  public function updatePersonalInfo(updatePersonalInfo $request)
  {

    $data = $request->validated();

    $response = $this->trainerService->updatePersonalInfo($data);

    if ($response['success'] == true) {
      return redirect()->route('show_trainer_profile')->with('success', $response['msg']);
    } else {
      return back()->withErrors(['error' => $response['msg']]);
    }
  }


  public function updateExperiance(updateExperiance $request)
  {

    $data = $request->validated();

    $response = $this->trainerService->updateExperiance($data);

    if ($response['success'] == true) {
      return redirect()->route('show_trainer_profile')->with('success', $response['msg']);
    } else {
      return back()->withErrors(['error' => $response['msg']]);
    }
  }


  public function updateContactinfo(updateContactInfo $request)
  {

    $data = $request->validated();

    $response = $this->trainerService->updateContactinfo($data);

    if ($response['success'] == true) {
      return redirect()->route('show_trainer_profile')->with('success', $response['msg']);
    } else {
      return back()->withErrors(['error' => $response['msg']]);
    }
  }
}
