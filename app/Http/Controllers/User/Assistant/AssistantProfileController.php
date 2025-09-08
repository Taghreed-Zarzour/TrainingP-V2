<?php

namespace App\Http\Controllers\User\Assistant;

use App\Enums\SexEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assistantrequests\updateExperienceAndEducation;
use App\Http\Requests\Assistantrequests\updatePersonalInfo;
use App\Models\Assistant;
use App\Models\Country;
use App\Models\ExperienceArea;
use App\Models\Language;
use App\Models\ProvidedService;
use App\Models\User;
use App\Services\AssistantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EducationLevel;

class AssistantProfileController extends Controller
{
    protected $assistantService;

    public function __construct(AssistantService $assistantService)
    {
      $this->assistantService = $assistantService;
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
        $user = User::with('country')->findOrFail($userId);
        $assistant = Assistant::where('id', $userId)->firstOrFail();
        $sexs = SexEnum::cases();
        $provided_services = ProvidedService::all();
        $countries = Country::all();
        $experience_areas = ExperienceArea::all();
        $languages = Language::all();
        $education_levels = EducationLevel::all();
        $assistant_providedServices = ProvidedService::whereIn('id', $assistant->provided_services ?? [])->get();

        $assistant_experience_areas = ExperienceArea::whereIn('id', $assistant->experience_areas ?? [])->get();

        $assistant_languages = Language::whereIn('id', $assistant->languages ?? [])->get();

        $selected_country = Country::where('phonecode', ltrim($user->phone_code, '+'))->first();

      return view('user.assistant.show_profile',
      compact('user','assistant','sexs','assistant_providedServices','countries','provided_services','selected_country','experience_areas',
        'assistant_experience_areas','languages','assistant_languages','education_levels'));
    }

    public function updatePersonalInfo(updatePersonalInfo $request){

        $data = $request->validated();

        $response = $this->assistantService->updatePersonalInfo($data);

        if ($response['success'] == true) {
          return redirect()->route('show_assistant_profile')->with('success', $response['msg']);
        } else {
          return back()->withErrors(['error' => $response['msg']]);
        }
    }

    public function updateExperienceAndEducation(updateExperienceAndEducation $request){

        $data = $request->validated();

        $response = $this->assistantService->updateExperienceAndEducation($data);

        if ($response['success'] == true) {
          return redirect()->route('show_assistant_profile')->with('success', $response['msg']);
        } else {
          return back()->withErrors(['error' => $response['msg']]);
        }
    }

}
