<?php

namespace App\Http\Controllers\User\Trainee;

use App\Enums\SexEnum;
use App\Enums\TrainingAttendanceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TraineeRequests\updatePreferredTimes;
use App\Http\Requests\TraineeRequests\updateProfessionalData;
use App\Http\Requests\TraineeRequests\updatePersonalInfo;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\Trainee;
use App\Models\User;
use App\Models\WorkField;
use App\Models\WorkSector;
use App\Services\TraineeService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class TraineeProfileController extends Controller
{
protected $TraineeService;

  public function __construct(TraineeService $TraineeService)
  {
    $this->TraineeService = $TraineeService;
  }

    public function showProfile($id = null)
{
     $id = $id ?? Auth::id(); // إذا لم يُرسل id، استخدم المعرّف الحالي
    $user = User::with('country')->findOrFail($id);
    $trainee = Trainee::where('id', $id)->firstOrFail();
    $sexs = SexEnum::cases();
    $countries = Country::all();
    $education_levels = EducationLevel::all();
    $training_attendance = TrainingAttendanceType::cases();
    $preferred_times = $trainee->preferred_times ?? [];
    $fields_of_interest = $trainee->fields_of_interest ?? [];


    $selected_country = Country::where('phonecode', ltrim($user->phone_code, '+'))->first();

    return view('user.trainee.show_profile',compact('user','trainee','sexs','countries',
    'education_levels','training_attendance','preferred_times','fields_of_interest','selected_country'));
}

public function updatePersonalInfo(updatePersonalInfo $request){

    $data = $request->validated();

    $response = $this->TraineeService->updatePersonalInfo($data);

    if ($response['success'] == true) {
      return redirect()->route('show_trainee_profile')->with('success', $response['msg']);
    } else {
return back()->withErrors(['error' => $response['msg']])->withInput();
    }
}

public function updateProfessionalData(updateProfessionalData $request){

    $data = $request->validated();

    $response = $this->TraineeService->updateProfessionalData($data);

    if ($response['success'] == true) {
      return redirect()->route('show_trainee_profile')->with('success', $response['msg']);
    } else {
      return back()->withErrors(['error' => $response['msg']]);
    }
}

public function updatePreferredTimes(updatePreferredTimes $request){

    $data = $request->validated();

    $response = $this->TraineeService->updatePreferredTimes($data);

    if ($response['success'] == true) {
      return redirect()->route('show_trainee_profile')->with('success', $response['msg']);
    } else {
      return back()->withErrors(['error' => $response['msg']]);
    }
}


}
