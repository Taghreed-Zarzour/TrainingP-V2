<?php

namespace App\Http\Controllers\User\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerRequests\rejectParticipantRequst;
use App\Models\Enrollment;
use App\Models\User;
use App\Notifications\EnrollmentAcceptedNotification;
use App\Notifications\EnrollmentRejectedMessageNotification;
use App\Notifications\EnrollmentRejectedNotification;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;

class TrainingParticipantsController extends Controller
{

    public function handleAction(Request $request, $programId, $participantId)
{
    $action = $request->input('action');
    $isOrgProgram = $request->input('is_org', false);

    $query = Enrollment::where('trainee_id', $participantId);
    if ($isOrgProgram) {
        $query->where('org_training_programs_id', $programId);
    } else {
        $query->where('training_programs_id', $programId);
    }
    $enrollment = $query->firstOrFail();

    $trainee = User::find($query->firstOrFail()->trainee_id);
  
if ($action === 'accept') {
    NotificationHelper::sendNotification(
        $trainee->id,
        'تم قبول تسجيلك في البرنامج',
        'enrollmentAccepted',
        ['program_id' => $programId]
    );
    $enrollment->status = 'accepted';
} elseif ($action === 'reject') {
    $enrollment->status = 'rejected';
    NotificationHelper::sendNotification(
        $trainee->id,
        'تم رفض تسجيلك في البرنامج',
        'enrollmentRejected',
        ['program_id' => $programId]
    );
}

    $enrollment->save();

    return back()->with('success', 'تم تحديث حالة المتدرب بنجاح');
}

public function submitReason(rejectParticipantRequst $request, $programId, $participantId)
{

    $isOrgProgram = $request->input('is_org', false);

    $trainee = User::find($participantId);
    $query = Enrollment::where('trainee_id', $participantId)
                       ->where('status', 'rejected');

    if ($isOrgProgram) {
        $query->where('org_training_programs_id', $programId);
    } else {
        $query->where('training_programs_id', $programId);
    }

    $enrollment = $query->firstOrFail();

    $enrollment->rejection_reason = $request->input('rejection_reason');
    $enrollment->save();

NotificationHelper::sendNotification(
    $trainee->id,
    'تم رفض تسجيلك في البرنامج بسبب: ' . $request->input('rejection_reason'),
    'enrollmentRejected',
    [
        'program_id' => $programId,
        'rejection_reason' => $request->input('rejection_reason')
    ]
);
    return redirect()->back()->with('success', 'تم حفظ سبب الرفض بنجاح.');
}



public function bulkAccept(Request $request, $programId)
{
    $isOrgProgram = $request->input('is_org', false);
    $query = Enrollment::where('status', 'pending');

    if ($isOrgProgram) {
        $query->where('org_training_programs_id', $programId);
    } else {
        $query->where('training_programs_id', $programId);
    }

    $enrollments = $query->get();
    foreach ($enrollments as $enrollment) {
        $enrollment->update(['status' => 'accepted']);
NotificationHelper::sendNotification(
    $enrollment->trainee->id,
    'تم قبول تسجيلك في البرنامج',
    'enrollmentAccepted',
    ['program_id' => $programId]
);    }

    return back()->with('success', 'تم قبول جميع المتدربين بنجاح.');
}


public function deleteAcceptedTrainee(Request $request, $trainee_id, $program_id)
{
    $isOrgProgram = $request->input('is_org', false);
    $query = Enrollment::where('trainee_id', $trainee_id);

    if ($isOrgProgram) {
        $query->where('org_training_programs_id', $program_id);
    } else {
        $query->where('training_programs_id', $program_id);
    }
    $traineeEnrollment = $query->firstOrFail();
    $traineeEnrollment->update(['status' => 'rejected']);
    
    return back()->with('success', 'تم حذف المتدرب بنجاح.');
}

}
