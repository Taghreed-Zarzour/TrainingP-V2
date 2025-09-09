<?php

namespace App\Http\Controllers\OrgTrainings;

use App\Http\Controllers\Controller;
use App\Http\Requests\orgTrainingProgram\storeOrgAssistantRequset;
use App\Http\Requests\orgTrainingProgram\updateSchedulingRequest;
use App\Models\Assistant;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\Enrollment;
use App\Models\Language;
use App\Models\OrgAssistantManagement;
use App\Models\OrgRegistrationAndRequirement;
use App\Models\OrgSessionAttendance;
use App\Models\OrgTrainingDetail;
use App\Models\OrgTrainingDetailFile;
use App\Models\OrgTrainingProgram;
use App\Models\OrgTrainingSchedule;
use App\Models\programType;
use App\Models\schedulingTrainingSessions;
use App\Models\SessionAttendance;
use App\Models\Trainee;
use App\Models\trainingAssistantManagement;
use App\Models\TrainingClassification;
use App\Models\trainingLevel;
use App\Models\TrainingProgram;
use App\Models\User;
use App\Models\WorkSector;
use App\Services\EnrollmentService;
use App\Services\OrgTrainingManagerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrgTrainingManagerController extends Controller
{

    protected $enrollmentService;
    protected $OrgTrainingManagerService;
    protected $stepKeys = ['program', 'detail', 'setting', 'sessions'];


    public function __construct(OrgTrainingManagerService $OrgTrainingManagerService, EnrollmentService $enrollmentService)
    {
      $this->OrgTrainingManagerService = $OrgTrainingManagerService;
      $this->enrollmentService = $enrollmentService;
    }

  public function index()
  {
      $categorized = $this->OrgTrainingManagerService->categorizePrograms();
      return view('orgTrainings.index', [
          'drafts' => $categorized['draft'] ?? [],
          'announced' => $categorized['announced'] ?? [],
          'ongoing' => $categorized['ongoing'] ?? [],
          'completed' => $categorized['completed'] ?? [],
          'stoppedPrograms' => $categorized['stopped'] ?? [],
      ]);
  }

    public function show($id)
    {
        $OrgProgram = OrgTrainingProgram::with(
            'details',
            'goals',
            'registrationRequirements',
            'assistants',
        )->where('status', 'online')->findOrFail($id);

        $trainingClassificationIds =  $OrgProgram->org_training_classification_id;
        $orgTrainingClassification = TrainingClassification::whereIn('id',$trainingClassificationIds)->pluck('name');

        $eduaction_levels_ids =  $OrgProgram->goals->first()->education_level_id;
        $education_levels = EducationLevel::whereIn('id',$eduaction_levels_ids)->pluck('name');

        $work_sector_ids =  $OrgProgram->goals->first()->work_sector_id;
        $work_sectors = WorkSector::whereIn('id',$work_sector_ids)->pluck('name');



      // المسجلون
      $participantIds = Enrollment::where('org_training_programs_id', $id)->pluck('trainee_id');
      $participants = Trainee::whereIn('id', $participantIds)
    ->with(['enrollments' => function ($query) use ($id) {
        $query->where('org_training_programs_id', $id);
    }])->get();


    // المتدربون
    $traineeIds = Enrollment::where('org_training_programs_id', $id)->where('status', 'accepted')->pluck('trainee_id');
    $trainees = Trainee::whereIn('id', $traineeIds)->get();

    //نسبة الحضور
    $totalSessions = OrgTrainingSchedule::whereHas('trainingProgram', function ($query) use($id){
        $query->whereHas('trainingProgram',function($query)use($id){
            $query->where('org_training_program_id',$id);
        });
    })->pluck('id');

      $attendanceStats = [];

      foreach ($trainees as $trainee) {
        $attendedSessions = OrgSessionAttendance::where('trainee_id', $trainee->id)
          ->where('attended', 1)
          ->whereIn('session_id', $totalSessions)
          ->count();

  $sessionCount = count($totalSessions);
  $percentage = $sessionCount > 0
      ? round(($attendedSessions / $sessionCount) * 100, 2)
      : 0;
        $attendanceStats[$trainee->id] = $percentage;
      }

      //حالة الجلسة لكل جلسة
      $sessionStatuses = [];
      $sessionAttendanceCounts = [];
      $now = Carbon::now();
        foreach($OrgProgram->details as $detail){
            foreach ($detail->trainingSchedules as $session) {
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

                $attendeeCount = OrgSessionAttendance::where('session_id', $session->id)
                ->where('attended', 1)
                ->count();

              $sessionAttendanceCounts[$session->id] = $attendeeCount;
            }
        }

    //Assistants
    $assistants= User::where('user_type_id',2)->with('assistant')->get();

    //نسبة الحضور العامة
      $totalSessionsCount = count($totalSessions);
      $totalTraineesCount = count($trainees);
      $totalExpectedAttendance = $totalSessionsCount * $totalTraineesCount;
      $totalActualAttendance = OrgSessionAttendance::whereIn('session_id', $totalSessions)
        ->where('attended', 1)
        ->count();

      if ($totalExpectedAttendance > 0) {
        $overallAttendancePercentage = round(($totalActualAttendance / $totalExpectedAttendance) * 100, 2);
      } else {
        $overallAttendancePercentage = 0;
      }


    //   الملفات

      $attachments = OrgTrainingDetailFile::where('org_training_program_id',$id)->get();

      return view('orgTrainings.training-manager', compact(
        'OrgProgram',
        'work_sectors',
        'orgTrainingClassification',
        'education_levels',
        'assistants',
        'participants',
        'attendanceStats',
        'sessionStatuses',
        'trainees',
        'sessionAttendanceCounts',
        'overallAttendancePercentage',
        'attachments',


      ));
    }



    public function showProgramDetail($id)
    {
        $OrgProgramDetail = OrgTrainingDetail::with(
            'trainingProgram',
            'trainingSchedules',
            'trainer',
        )->findOrFail($id);

        $trainingClassificationIds =  $OrgProgramDetail->trainingProgram->org_training_classification_id;
        $orgTrainingClassification = TrainingClassification::whereIn('id',$trainingClassificationIds)->pluck('name');

        $education_levels_ids =  $OrgProgramDetail->trainingProgram->goals->first()->education_level_id;
        $education_levels = EducationLevel::whereIn('id',$education_levels_ids)->pluck('name');

        $work_sector_ids =  $OrgProgramDetail->trainingProgram->goals->first()->work_sector_id;
        $work_sectors = WorkSector::whereIn('id',$work_sector_ids)->pluck('name');

        $org_training_programs_id = $OrgProgramDetail->trainingProgram->id;
        $OrgProgram = OrgTrainingProgram::where('id', $org_training_programs_id)->get();
        // المتدربون
        $traineeIds = Enrollment::where('org_training_programs_id', $org_training_programs_id)->where('status', 'accepted')->pluck('trainee_id');
        $trainees = Trainee::whereIn('id', $traineeIds)->get();

        //نسبة الحضور
        $totalSessions = OrgTrainingSchedule::where('org_training_detail_id',$id)->pluck('id');
        $attendanceStats = [];
        foreach ($trainees as $trainee) {
            $attendedSessions = OrgSessionAttendance::where('trainee_id', $trainee->id)
            ->where('attended', 1)
            ->whereIn('session_id', $totalSessions)
            ->count();

        $sessionCount = count($totalSessions);
        $percentage = $sessionCount > 0
            ? round(($attendedSessions / $sessionCount) * 100, 2)
            : 0;
                $attendanceStats[$trainee->id] = $percentage;
        }

      //حالة الجلسة لكل جلسة
      $sessionStatuses = [];
      $sessionAttendanceCounts = [];
      $now = Carbon::now();
            foreach ($OrgProgramDetail->trainingSchedules as $session) {
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

                $attendeeCount = OrgSessionAttendance::where('session_id', $session->id)
                ->where('attended', 1)
                ->count();

              $sessionAttendanceCounts[$session->id] = $attendeeCount;
            }


    //نسبة الحضور العامة
      $totalSessionsCount = count($totalSessions);
      $totalTraineesCount = count($trainees);
      $totalExpectedAttendance = $totalSessionsCount * $totalTraineesCount;
      $totalActualAttendance = OrgSessionAttendance::whereIn('session_id', $totalSessions)
        ->where('attended', 1)
        ->count();

      if ($totalExpectedAttendance > 0) {
        $overallAttendancePercentage = round(($totalActualAttendance / $totalExpectedAttendance) * 100, 2);
      } else {
        $overallAttendancePercentage = 0;
      }

    //   الملفات
      $attachments = OrgTrainingDetailFile::where('org_training_program_id', $org_training_programs_id)->get();

      return view('orgTrainings.training.training-manager', compact(
        'OrgProgram',
        'work_sectors',
        'orgTrainingClassification',
        'education_levels',
        'attendanceStats',
        'sessionStatuses',
        'trainees',
        'sessionAttendanceCounts',
        'overallAttendancePercentage',
        'attachments',
      ));
    }

    public function destroy($id)
    {
      $program = OrgTrainingProgram::findOrFail($id);
        $program->details()->delete();
        $program->delete();

      return redirect()->back()->with('deleted', true);

    }
  public function deleteOrgTraining($id)
    {

      $program = OrgTrainingDetail::findOrFail($id);

        $program->trainingSchedules()->delete();
        $program->delete();

      return redirect()->back()->with('deleted', true);

    }
    public function deleteOrgSession($id){

    $session = OrgTrainingSchedule::findOrFail($id);
    $session->delete();

    return redirect()->back()->with('success', 'تم حذف الجلسة بنجاح');
    }

    public function updateOrgSession(updateSchedulingRequest $request, $id){
        $session = OrgTrainingSchedule::findOrFail($id);

        $data= $request->validated();

        $session->update($data);
        $session->save();

        return redirect()->back()->with('success', 'Session updated successfully.');
    }


    public function updateOrgImage(Request $request, $id)
{
    $settings = OrgRegistrationAndRequirement::findOrFail($id);

    if ($request->hasFile('training_image')) {
        $originalName = $request->file('training_image')->getClientOriginalName();
        $path = 'training/training_image/' . $originalName;

        $request->file('training_image')->storeAs('training/training_image', $originalName, 'public');

        if ($settings->training_image) {
            Storage::disk('public')->delete($settings->training_image);
        }

        $settings->training_image = $path;
        $settings->save();
    }

    return redirect()->back()->with('success', 'Training image updated successfully.');
}

public function deleteOrgImage($id)
{
    $settings = OrgRegistrationAndRequirement::findOrFail($id);

    if ($settings->training_image) {
        Storage::disk('public')->delete($settings->training_image);
        $settings->training_image = null;
        $settings->save();
    }

    return redirect()->back()->with('success', 'Training image deleted successfully.');
}

public function deleteOrgAssistant($orgTraining_id, $assistant_id)
{
    $assistant = OrgAssistantManagement::where('assistant_id',$assistant_id)
                ->where('org_training_program_id',$orgTraining_id)->first();

    $assistant->delete();

    return redirect()->back()->with('success', 'تم حذف الجلسة بنجاح');
}

public function storeOrgAssistant(storeOrgAssistantRequset $request)
{
    $data = $request->validated();

    $assistantManager = OrgAssistantManagement::create([
        'org_training_program_id' => $data['orgTraining_id'],
        'assistant_id' => $data['assistant_id']
    ]);

    $assistantManager->save();

    return redirect()->back()->with('success', 'تمت إضافة الميسر بنجاح');
}

public function enroll($OrgProgram_id)
  {
    $response = $this->enrollmentService->store(program_id: null, orgProgram_id: $OrgProgram_id);

    if ($response['success'] == true) {

      return redirect()->back()->with('success', $response['msg']);
    } else {
      return back()->withErrors(['error' => $response['msg']]);
    }

  }

  public function selectSessionAttendance(OrgTrainingSchedule $session, Request $request)
  {
    $viewType = request()->query('view', 'default');

    $programId = $session->trainingProgram->trainingProgram->id;

    $traineeIds = Enrollment::where('org_training_programs_id', $programId)
      ->where('status', 'accepted')
      ->pluck('trainee_id');

    $session_attendance_ids = OrgSessionAttendance::where('session_id', $session->id)
      ->where('attended', 1)
      ->pluck('trainee_id');


    $trainees = Trainee::whereIn('id', $traineeIds)
      ->whereNotIn('id', $session_attendance_ids)->with('user')->get();

    $session_attendance = Trainee::whereIn('id', $session_attendance_ids)
      ->with('user') ->get();

    return view('orgTrainings.training-manager-attendance', compact(
      'session',
      'trainees',
      'session_attendance',
      'viewType'
    ));
  }

  public function storeSessionAttendance(Request $request, OrgTrainingSchedule $session)
  {
    $attendedIds = $request->input('attended', []);

    $programId = $session->trainingProgram->trainingProgram->id;

    $traineeIds = Enrollment::where('org_training_programs_id', $programId)->pluck('trainee_id');

    foreach ($traineeIds as $traineeId) {
      $isPresent = in_array($traineeId, $attendedIds);
     if ($isPresent == 1) {
        OrgSessionAttendance::updateOrCreate([
        'session_id' => $session->id,
        'trainee_id' => $traineeId,
        'attended' => 1,
      ]);
    }
  }
    return redirect()->back()->with('success', 'تم تسجيل الحضور بنجاح!');
  }

  public function showSessionAttendance(OrgTrainingSchedule $session)
  {
    $session_attendance_ids = OrgSessionAttendance::where('attended', 1)->pluck('trainee_id');
    $session_attendance = Trainee::where('id', $session_attendance_ids)->get();

    return view('orgTrainings.training-manager-attendance', compact('session', 'session_attendance'));
  }



    public function stopSharing($id)
    {
      $this->OrgTrainingManagerService->stopSharing($id);
      return redirect()->route('orgTrainingsManager.index')->with('stopped', true);
    }
    public function rePublish($id)
    {
      $this->OrgTrainingManagerService->rePublish($id);
      return redirect()->route('orgTrainingsManager.index')->with('online', true);
    }
    public function showStoppedPrograms()
    {
      $stoppedPrograms = $this->OrgTrainingManagerService->displayStoppedTraining()->get();

      return view('orgTrainings.index', compact('stoppedPrograms'));
    }
}
