<?php

namespace App\Http\Controllers\User\Trainee;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;

class RegisteredTrainingsController extends Controller
{
    public function trainings($trainee_id){

        $programs = TrainingProgram::with(['detail', 'AdditionalSetting', 'sessions', 'trainees'])
        ->whereHas('trainees', function ($query) use ($trainee_id) {
            $query->where('trainee_id', $trainee_id);
        })->get();

        return view('user.trainee.myTrainings',compact('programs'));
    }
}
