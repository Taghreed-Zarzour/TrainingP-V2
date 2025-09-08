<?php

namespace App\Http\Controllers\OrgTrainings;

use App\Http\Controllers\Controller;
use App\Models\OrgTrainingDetail;
use App\Models\OrgTrainingSchedule;
use App\Models\Trainer;
use Illuminate\Http\Request;

class UpdateTrainingController extends Controller
{
    public function show($id){
        $training = OrgTrainingDetail::with([
            'trainingSchedules',
            'trainer'
        ])
        ->findOrFail($id);
        $training->increment('views');
        $trainers = Trainer::all();
        return view('orgTrainings.training.show',compact('training','trainers'));
    }
public function update(Request $request, $id)
{
    $request->validate([
        'program_title' => 'nullable|string|max:255',
        'trainer_id' => 'nullable|exists:trainers,id',
        'session_ids' => 'array',
        'session_dates.*' => 'required|date',
        'session_start_times.*' => 'required|date_format:H:i',
        'session_end_times.*' => 'required|date_format:H:i|after:session_start_times.*',
    ]);

    $training = OrgTrainingDetail::findOrFail($id);
    
    if ($request->has('program_title')) {
        $training->program_title = $request->input('program_title');
    }

    if ($request->has('trainer_id')) {
        $training->trainer_id = $request->input('trainer_id');
    }
    $training->save();

    if ($request->has('session_ids')) {
        foreach ($request->session_ids as $sessionId) {
            $session = OrgTrainingSchedule::findOrFail($sessionId);
            $session->session_date = $request->session_dates[$sessionId];
            $session->session_start_time = $request->session_start_times[$sessionId];
            $session->session_end_time = $request->session_end_times[$sessionId];
            $session->save();
        }
    }
    return redirect()->route('organization.showSpecificTraining', $id)->with('success', 'Training details updated successfully.');
}
public function storeSession(Request $request, $trainingId)
{
    // Validate the incoming request data
    $request->validate([
        'session_date' => 'required|date',
        'session_start_time' => 'required|date_format:H:i',
        'session_end_time' => 'required|date_format:H:i|after:session_start_time',
    ]);

    // Check if a session with the same date and time already exists
    $existingSession = OrgTrainingSchedule::where('org_training_detail_id', $trainingId)
        ->where('session_date', $request->session_date)
        ->where('session_start_time', $request->session_start_time)
        ->where('session_end_time', $request->session_end_time)
        ->first();

    if ($existingSession) {
        return redirect()->back()->withErrors('error', 'This session already exists.');   
    }

    // Create a new session
    OrgTrainingSchedule::create([
        'org_training_detail_id' => $trainingId,
        'session_date' => $request->session_date,
        'session_start_time' => $request->session_start_time,
        'session_end_time' => $request->session_end_time,
    ]);

    return redirect()->route('organization.showSpecificTraining', $trainingId)->with('success', 'Session added successfully.');}
}
