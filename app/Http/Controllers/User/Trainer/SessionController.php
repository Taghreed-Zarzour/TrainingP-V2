<?php

namespace App\Http\Controllers\User\Trainer;

use App\Http\Controllers\Controller;
use App\Models\schedulingTrainingSessions;
use App\Http\Requests\TrainerRequests\sessionUpdateRequest;
use App\Http\Requests\TrainingCreate\StoreSchedulingRequest;
use App\Models\Enrollment;
use App\Models\SessionAttendance;
use App\Models\Trainee;
use Illuminate\Http\Request;


class SessionController extends Controller
{

  public function store(StoreSchedulingRequest $request, $program_id)
  {
    $validated = $request->validated();

    foreach ($validated['schedules'] as $sessionData) {
      $sessionData['training_program_id'] = $program_id;
      schedulingTrainingSessions::create($sessionData);
    }
    return redirect()->back()->with('success', 'تم إضافة الجلسة بنجاح');
  }

  public function destroy($id)
  {
    $session = schedulingTrainingSessions::findOrFail($id);
    $session->delete();

    return redirect()->back()->with('success', 'تم حذف الجلسة بنجاح');
  }

  public function update(sessionUpdateRequest $request, $id)
  {
    $data = $request->validated();

    $session = schedulingTrainingSessions::findOrFail($id);
    $session->update($data);
    $session->save();

    return redirect()->back()->with('success', 'تم تعديل الجلسة بنجاح');
  }


  // public function selectSessionAttendece(schedulingTrainingSessions $session, Request $request)
// {
//     $mode = $request->query('mode', 'select'); // Default to 'select' if no mode provided

  //     $programId = $session->trainingProgram->id;
//     $traineeIds = Enrollment::where('training_programs_id', $programId)
//                            ->where('status', 'accepted')
//                            ->pluck('trainee_id');

  //     $trainees = Trainee::whereIn('id', $traineeIds)->get();

  //     if ($mode === 'view') {
//         $session_attendance_ids = SessionAttendance::where('session_id', $session->id)
//                                                 ->where('attended', 1)
//                                                 ->pluck('trainee_id');
//         $trainees = Trainee::whereIn('id', $session_attendance_ids)->get();
//     }

  //     return view('trainings.attendance-select', compact('session', 'trainees', 'mode'));
// }

  public function selectSessionAttendece(schedulingTrainingSessions $session, Request $request)
  {
    $viewType = request()->query('view', 'default'); // default = تحديد

    $programId = $session->trainingProgram->id;

    // الحصول على جميع المسجلين المقبولين في البرنامج
    $traineeIds = Enrollment::where('training_programs_id', $programId)
      ->where('status', 'accepted')
      ->pluck('trainee_id');

    // الحصول على جميع الحضور المسجلين للجلسة
    $session_attendance_ids = SessionAttendance::where('session_id', $session->id)
      ->where('attended', 1)
      ->pluck('trainee_id');

    // المتدربون الذين يمكن تحديد حضورهم (لم يحضروا بعد)
    $trainees = Trainee::whereIn('id', $traineeIds)
      ->whereNotIn('id', $session_attendance_ids)
      ->with('user') // تحميل علاقة user مسبقاً
      ->get();

    // المتدربون الذين حضروا بالفعل
    $session_attendance = Trainee::whereIn('id', $session_attendance_ids)
      ->with('user') // تحميل علاقة user مسبقاً
      ->get();

    return view('trainings.attendance-select', compact(
      'session',
      'trainees',
      'session_attendance',
      'viewType'
    ));
  }




  public function storeSessionAttendece(Request $request, schedulingTrainingSessions $session)
  {
    $attendedIds = $request->input('attended', []);

    $programId = $session->trainingProgram->id;
    $traineeIds = Enrollment::where('training_programs_id', $programId)->pluck('trainee_id');

    foreach ($traineeIds as $traineeId) {
      $isPresent = in_array($traineeId, $attendedIds);
    
     if ($isPresent == 1) {
      SessionAttendance::updateOrCreate([
        'session_id' => $session->id,
        'trainee_id' => $traineeId,
        'attended' => 1,
      ]);
    }
  }
    return redirect()->route('sessions.attendance', [
      'session' => $session->id,
      'mode' => 'view' // انتقل لوضع العرض بعد التسجيل
    ])->with('success', 'تم تسجيل الحضور بنجاح!');
  }

  public function showSessionAttendece(schedulingTrainingSessions $session)
  {
    $session_attendance_ids = SessionAttendance::where('attended', 1)->pluck('trainee_id');
    $session_attendance = Trainee::where('id', $session_attendance_ids)->get();

    return view('trainings.attendance-select', compact('session', 'session_attendance'));
  }




}
