<?php

namespace App\Http\Controllers\User\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerRequests\rejectParticipantRequst;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class TrainingParticipantsController extends Controller
{

    public function handleAction(Request $request, $programId, $participantId)
{
    $action = $request->input('action');

    $enrollment = Enrollment::where('trainee_id', $participantId)
                            ->where('training_programs_id', $programId)
                            ->firstOrFail();

    if ($action === 'accept') {
        $enrollment->status = 'accepted';
    } elseif ($action === 'reject') {
        $enrollment->status = 'rejected';
    }

    $enrollment->save();

    return back()->with('success', 'تم تحديث حالة المتدرب بنجاح');
}

public function submitReason(rejectParticipantRequst $request, $programId, $participantId)
{

    $enrollment = Enrollment::where('trainee_id',$participantId)->where('training_programs_id', $programId)
                            ->where('status','rejected')->firstOrFail();

    $enrollment->rejection_reason = $request->input('rejection_reason');
    $enrollment->save();

    return redirect()->back()->with('success', 'تم حفظ سبب الرفض بنجاح.');
}



public function bulkAccept($programId)
{
    $enrollments = Enrollment::where('training_programs_id', $programId)->where('status','pending')->get();

    foreach ($enrollments as $enrollment) {
        $enrollment->status = 'accepted';
        $enrollment->save();
    }

    return back()->with('success', 'تم قبول جميع المتدربين بنجاح ');
}

public function deleteAcceptedTrainee($trainee_id, $program_id){

    $traineeEnrollment = Enrollment::where('trainee_id',$trainee_id)->where('training_programs_id',$program_id)->first();
    $traineeEnrollment->status = 'rejected';
    $traineeEnrollment->save();

    return back()->with('success', 'تم حذف المتدرب بنجاح');

}

}
