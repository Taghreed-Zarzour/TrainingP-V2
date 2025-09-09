<?php

namespace App\Http\Controllers\User\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerRequests\rejectParticipantRequst;
use App\Http\Requests\TrainingAnnouncementRequests\storeAdditionalSettings;
use App\Http\Requests\TrainingAnnouncementRequests\updateTrainingInfo;
use App\Models\Assistant;
use App\Models\Country;
use App\Models\Enrollment;
use App\Models\Language;
use App\Models\programType;
use App\Models\User;
use App\Models\Enrollments;
use App\Models\schedulingTrainingSessions;
use App\Models\SessionAttendance;
use App\Models\Trainee;
use App\Notifications\OrgViewsNotification;
use Illuminate\Support\Facades\Storage;
use App\Models\trainingAssistantManagement;
use App\Models\TrainingClassification;
use App\Models\TrainingDetail;
use App\Models\trainingLevel;
use App\Models\TrainingProgram;
use App\Models\additional_setting;
use App\Services\TrainingProgramServices;
use App\Services\TrainingUpdateSessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Enums\TrainingAttendanceType;
use Illuminate\Support\Facades\DB;
use App\Helpers\NotificationHelper;

class TrainingProgramController extends Controller
{
  protected $trainingProgramService;
  protected $stepKeys = ['program', 'detail', 'setting', 'sessions'];

  public function __construct(TrainingProgramServices $trainingProgramService)
  {
    $this->trainingProgramService = $trainingProgramService;
  }

public function index()
{
    $categorized = $this->trainingProgramService->categorizePrograms();
    return view('trainings.index', [
        'drafts' => $categorized['draft'] ?? [],
        'announced' => $categorized['announced'] ?? [],
        'ongoing' => $categorized['ongoing'] ?? [],
        'completed' => $categorized['completed'] ?? [],
        'stoppedPrograms' => $categorized['stopped'] ?? [],
    ]);
}

  public function show(Request $request, $id)
  {
    $search = $request->input('search');

    $program = TrainingProgram::with([
      'detail',
      'AdditionalSetting',
      'sessions',
      'assistants'
    ])->findOrFail($id);

    // المشاهدات
    $program->increment('views');
$programUser = User::find($program->user_id);
if ($program->views % 30 === 0) {
    NotificationHelper::sendNotification(
        $programUser->id,
        'لقد تم مشاهدة برنامجك ' . $program->views . ' مرة.',
        'views',
        ['views' => $program->views, 'program_id' => $program->id]
    );
}
    $programTypes = ProgramType::pluck('name', 'id');
    $languages = Language::pluck('name', 'id');
    $classifications = TrainingClassification::pluck('name', 'id');
    $levels = TrainingLevel::pluck('name', 'id');
    $countries = Country::pluck('name', 'id');

    // المدرب
    $trainerId = TrainingProgram::where('id', $id)->value('user_id');
    $trainer = User::find($trainerId);

    // المسجلون
    $participantIds = Enrollment::where('training_programs_id', $id)->pluck('trainee_id');
    if($search){
            $participants = Trainee::whereIn('id', $participantIds)
            ->where('last_name->ar','like',"%{$search}%")
            ->orWhereHas('user', fn($q) => $q->where('first_name->ar','like',"%{$search}%"))->get();
    }
    else{
        $participants = Trainee::whereIn('id', $participantIds)->get();
    }


    // المتدربون
    $traineeIds = Enrollment::where('training_programs_id', $id)->where('status', 'accepted')->pluck('trainee_id');
    $trainees = Trainee::whereIn('id', $traineeIds)->get();

    // مساعدو المدرب
    $assistantLinks = trainingAssistantManagement::where('training_program_id', $id)->with('assistant')->get();
    $assistants = $assistantLinks->pluck('assistant')->filter(); // filter() تحذف كل null

    $availableAssistants = Assistant::all();

    //نسبة الحضور
    $totalSessions = schedulingTrainingSessions::where('training_program_id', $id)->pluck('id');
    $attendanceStats = [];

    foreach ($trainees as $trainee) {
      $attendedSessions = SessionAttendance::where('trainee_id', $trainee->id)
        ->where('attended', 1)
        ->whereIn('session_id', $totalSessions)
        ->count();

$sessionCount = count($totalSessions);
$percentage = $sessionCount > 0
    ? round(($attendedSessions / $sessionCount) * 100, 2)
    : 0;
      $attendanceStats[$trainee->id] = $percentage;
    }

    //حالة الجلسة وعدد الحضور لكل جلسة
    $sessionStatuses = [];
    $sessionAttendanceCounts = [];
    $now = Carbon::now();

    foreach ($program->sessions as $session) {
      $date = $session->session_date;
      $startTime = $session->session_start_time;
      $endTime = $session->session_end_time;

      $sessionStart = Carbon::createFromFormat('Y-m-d H:i:s', "$date $startTime");
      $sessionEnd = Carbon::createFromFormat('Y-m-d H:i:s', "$date $endTime");

      if ($sessionEnd->lessThan($sessionStart)) {
        $sessionEnd->addDay();
      }

      if ($now->lt($sessionStart)) {
        $status = 'لم تبدأ';
      } elseif ($now->between($sessionStart, $sessionEnd)) {
        $status = 'قيد التقدم';
      } else {
        $status = 'مكتمل';
      }

      $sessionStatuses[$session->id] = $status;




      $attendeeCount = SessionAttendance::where('session_id', $session->id)
        ->where('attended', 1)
        ->count();

      $sessionAttendanceCounts[$session->id] = $attendeeCount;
    }

    //نسبة الحضور العامة
    $totalSessionsCount = count($totalSessions);
    $totalTraineesCount = count($trainees);
    $totalExpectedAttendance = $totalSessionsCount * $totalTraineesCount;
    $totalActualAttendance = SessionAttendance::whereIn('session_id', $totalSessions)
      ->where('attended', 1)
      ->count();

    if ($totalExpectedAttendance > 0) {
      $overallAttendancePercentage = round(($totalActualAttendance / $totalExpectedAttendance) * 100, 2);
    } else {
      $overallAttendancePercentage = 0;
    }

    return view('trainings.training-details', compact(
      'program',
      'programTypes',
      'languages',
      'classifications',
      'levels',
      'countries',
      'trainer',
      'participants',
      'trainees',
      'assistants',
      'availableAssistants',
      'attendanceStats',
      'sessionStatuses',
      'sessionAttendanceCounts',
      'overallAttendancePercentage',
    ));
  }


  public function destroy($id)
  {
    $this->trainingProgramService->deleteProgram($id);
    return redirect()->route('trainings.index')->with('deleted', true);
  }
  public function stopSharing($id)
  {
    $this->trainingProgramService->stopSharing($id);
    return redirect()->route('trainings.index')->with('stopped', true);
  }
  public function rePublish($id)
  {
    $this->trainingProgramService->rePublish($id);
    return redirect()->route('trainings.index')->with('online', true);
  }
  public function showStoppedPrograms()
  {
    $stoppedPrograms = $this->trainingProgramService->displayStoppedTraining()->get();

    return view('trainings.stopped', compact('stoppedPrograms'));
  }

}
