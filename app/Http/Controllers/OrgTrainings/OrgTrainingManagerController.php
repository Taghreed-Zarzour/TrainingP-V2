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
use App\Models\OrgTrainingDetail;
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
use App\Services\OrgTrainingManagerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrgTrainingManagerController extends Controller
{
    protected $OrgTrainingManagerService;
    protected $stepKeys = ['program', 'detail', 'setting', 'sessions'];

    public function __construct(OrgTrainingManagerService $OrgTrainingManagerService)
    {
      $this->OrgTrainingManagerService = $OrgTrainingManagerService;
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

      // المشاهدات
    //   $program->increment('views');


//       // المسجلون
//       $participantIds = Enrollment::where('training_programs_id', $id)->pluck('trainee_id');
//       $participants = Trainee::whereIn('id', $participantIds)->get();

//       // المتدربون
//       $traineeIds = Enrollment::where('training_programs_id', $id)->where('status', 'accepted')->pluck('trainee_id');
//       $trainees = Trainee::whereIn('id', $traineeIds)->get();

//       //نسبة الحضور
//       $totalSessions = schedulingTrainingSessions::where('training_program_id', $id)->pluck('id');
//       $attendanceStats = [];

//       foreach ($trainees as $trainee) {
//         $attendedSessions = SessionAttendance::where('trainee_id', $trainee->id)
//           ->where('attended', 1)
//           ->whereIn('session_id', $totalSessions)
//           ->count();

//   $sessionCount = count($totalSessions);
//   $percentage = $sessionCount > 0
//       ? round(($attendedSessions / $sessionCount) * 100, 2)
//       : 0;
//         $attendanceStats[$trainee->id] = $percentage;
//       }

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
            }
        }

        //Assistants
        $assistants= User::where('user_type_id',2)->with('assistant')->get();
//       //نسبة الحضور العامة
//       $totalSessionsCount = count($totalSessions);
//       $totalTraineesCount = count($trainees);
//       $totalExpectedAttendance = $totalSessionsCount * $totalTraineesCount;
//       $totalActualAttendance = SessionAttendance::whereIn('session_id', $totalSessions)
//         ->where('attended', 1)
//         ->count();

//       if ($totalExpectedAttendance > 0) {
//         $overallAttendancePercentage = round(($totalActualAttendance / $totalExpectedAttendance) * 100, 2);
//       } else {
//         $overallAttendancePercentage = 0;
//       }

      return view('orgTrainings.training-manager', compact(
        'OrgProgram',
        'work_sectors',
        'orgTrainingClassification',
        'education_levels',
        'assistants',
        // 'attendanceStats',
        'sessionStatuses',
        // 'sessionAttendanceCounts',
        // 'overallAttendancePercentage',
      ));
    }


    public function destroy($id)
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




    public function stopSharing($id)
    {
      $this->OrgTrainingManagerService->stopSharing($id);
      return redirect()->route('trainings.index')->with('stopped', true);
    }
    public function rePublish($id)
    {
      $this->OrgTrainingManagerService->rePublish($id);
      return redirect()->route('trainings.index')->with('online', true);
    }
    public function showStoppedPrograms()
    {
      $stoppedPrograms = $this->OrgTrainingManagerService->displayStoppedTraining()->get();

      return view('trainings.stopped', compact('stoppedPrograms'));
    }
}
