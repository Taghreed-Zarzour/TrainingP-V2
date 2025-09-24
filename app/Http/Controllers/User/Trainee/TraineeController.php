<?php

namespace App\Http\Controllers\User\Trainee;

use App\Enums\SexEnum;
use App\Enums\TrainingAttendanceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TraineeRequests\completeRegisterRequest;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\User;
use App\Models\WorkField;
use App\Models\WorkSector;
use App\Services\TraineeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TraineeController extends Controller
{
    protected $traineeService;

    public function __construct(TraineeService $traineeService)
    {
        $this->traineeService = $traineeService;
    }

    public function showRegistrationForm($id)
    {
        $user = User::findOrFail($id);
        $countries = Country::all();
        $nationalities = Country::all();
        $sexs = SexEnum::cases();
        $work_fields = WorkField::all();
        $educatuin_levels = EducationLevel::all();
        $work_sectors = WorkSector::all();
        $training_attendance = TrainingAttendanceType::cases();

        return view('user.trainee.complete-register-form',
        compact('user', 'countries', 'nationalities', 'sexs', 'educatuin_levels', 'work_fields','work_sectors',
        'training_attendance'));

    }

    public function completeRegister(completeRegisterRequest $request, $id)
    {
        $validated = $request->validated();
        $response = $this->traineeService->completeRegister($validated, $id);

        if ($response['success'] == true) {
            return redirect()->route('homePage', ['id' => $id])
            ->with('success', $response['msg']);
        } else {
            return back()
            ->withInput()
            ->withErrors(['error' => $response['msg']]);
        }
    }


}
