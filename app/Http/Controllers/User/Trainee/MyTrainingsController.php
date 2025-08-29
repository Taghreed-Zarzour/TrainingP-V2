<?php

namespace App\Http\Controllers\User\Trainee;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\OrgTrainingProgram;
use App\Models\TrainingProgram;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyTrainingsController extends Controller
{
    public function index()
    {
        $scheduledTrainings = [];
        $scheduledOrgTrainings = [];

        $pausedTrainings = [];
        $pausedOrgTrainings = [];

        $ongoingTrainings = [];
        $ongoingOrgTrainings = [];

        $completedTrainings = [];
        $completedOrgTrainings = [];

        $trainee_id = Auth::id();
        $enrollments = Enrollment::where('trainee_id', $trainee_id)->get();

        foreach ($enrollments as $enrollment) {
            // Scheduled: pending or rejected
            if (in_array($enrollment->status, ['pending', 'rejected'])) {
                if ($enrollment->training_programs_id) {
                    $training = TrainingProgram::where('status', 'online')->find($enrollment->training_programs_id);
                    if ($training) {
                        $scheduledTrainings[] = [
                            'program' => $training,
                            'status' => $enrollment->status,
                        ];
                    }
                }

                if ($enrollment->org_training_programs_id) {
                    $orgTraining = OrgTrainingProgram::where('status', 'online')->find($enrollment->org_training_programs_id);
                    if ($orgTraining) {
                        $scheduledOrgTrainings[] = [
                            'program' => $orgTraining,
                            'status' => $enrollment->status,
                        ];
                    }
                }
            }

            if ($enrollment->status  == 'accepted'){
                if ($enrollment->training_programs_id) {
                    $training = TrainingProgram::where('status', 'online')->find($enrollment->training_programs_id);
                    if ($training) {
                        $firstSession = $training->sessions()->orderBy('session_date')->first();
                        if ($firstSession && $firstSession->session_date > now()) {
                            $scheduledTrainings[] = [
                                'program' => $training,
                                'status' => $enrollment->status,
                                'start_date' => $firstSession->session_date
                            ];
                        }
                    }
                }

                if ($enrollment->org_training_programs_id) {
                    $orgTraining = OrgTrainingProgram::where('status', 'online')->find($enrollment->org_training_programs_id);
                    if ($orgTraining) {
                        $firstDetail = $orgTraining->details()->orderBy('id')->first();

                        $firstSession = null;
                        if ($firstDetail) {
                            $firstSession = $firstDetail->trainingSchedules()->orderBy('session_date')->first();
                        }
                        if ($firstSession && Carbon::parse($firstSession->session_date)->greaterThan(now())) {
                            $scheduledOrgTrainings[] = [
                                'program' => $orgTraining,
                                'status' => $enrollment->status,
                                'start_date' => $firstSession->session_date
                            ];
                        }
                    }
                }
            }

            // Paused: status = stopped
            if ($enrollment->training_programs_id) {
                $training = TrainingProgram::where('status','offline')->find($enrollment->training_programs_id);
                    $pausedTrainings[] = $training;
            }

            if ($enrollment->org_training_programs_id) {
                $orgTraining = OrgTrainingProgram::where('status','offline')->find($enrollment->org_training_programs_id);
                    $pausedOrgTrainings[] = $orgTraining;
            }



            //ongoing and completed trainings
            if ($enrollment->status  == 'accepted'){
                if ($enrollment->training_programs_id) {
                    $training = TrainingProgram::where('status', 'online')->find($enrollment->training_programs_id);
                    if ($training) {
                        $totalSessions = $training->sessions()->count();
                        $completedSessions = $training->sessions()->where('session_date', '<', now())->count();
                        $completionRate = $totalSessions > 0 ? round(($completedSessions / $totalSessions) * 100, 2) : 0;
                        $training->completion_rate = $completionRate;
                        if ($completionRate > 0 && $completionRate < 100) {
                            $nextSession = $training->sessions()
                                ->where('session_date', '>', now())
                                ->orderBy('session_date')
                                ->first();
                            $ongoingTrainings[] = [
                                'program' => $training,
                                'completionRate' => $completionRate,
                                'nextSession' => $nextSession,

                            ];
                        } elseif ($completionRate == 100) {
                            $completedTrainings[] = [
                                'program' => $training,
                                'completionRate' => $completionRate,
                            ];
                        }
                    }
                }

                if ($enrollment->org_training_programs_id) {
                    $orgTraining = OrgTrainingProgram::where('status', 'online')->find($enrollment->org_training_programs_id);
                    if ($orgTraining) {
                        $allSchedules = $orgTraining->details()
                        ->with('trainingSchedules')
                        ->get()
                        ->flatMap(fn($detail) => $detail->trainingSchedules);
                        $totalSessions = $allSchedules->count();
                        $completedSessions = $allSchedules->filter(fn($session) => $session->session_date < now())->count();

                        $completionRate = $totalSessions > 0 ? round(($completedSessions / $totalSessions) * 100, 2) : 0;

                        $orgTraining->completion_rate = $completionRate;
                        if ($completionRate > 0 && $completionRate < 100) {
                            $nextSession = $orgTraining->details()
                                ->with('trainingSchedules')
                                ->get()
                                ->flatMap(fn($detail) => $detail->trainingSchedules)
                                ->filter(fn($session) => $session->session_date > now())
                                ->sortBy('session_date')
                                ->first();

                            $ongoingOrgTrainings[] = [
                                'program' => $orgTraining,
                                'completionRate' => $completionRate,
                                'nextSession' => $nextSession,
                            ];
                        } elseif ($completionRate == 100) {
                            $completedOrgTrainings[] = [
                                'program' => $orgTraining,
                                'completionRate' => $completionRate,
                            ];
                        }
                    }

                }
            }

        }

        foreach ($scheduledTrainings as &$item) {
            $program = $item['program'];
            $minutes = 0;

            if ($program->sessions) {
                foreach ($program->sessions as $session) {
                    $start = Carbon::createFromTimeString($session->session_start_time);
                    $end = Carbon::createFromTimeString($session->session_end_time);

                    $adjustedEnd = $end->copy();
                    if ($adjustedEnd->lessThanOrEqualTo($start)) {
                        $adjustedEnd->addDay();
                    }

                    $diff = $adjustedEnd->diffInMinutes($start, true);
                    $minutes += $diff;
                }
            }

            $program->total_duration_hours = round($minutes / 60, 2);
            $item['program'] = $program;
        }



        foreach ($pausedTrainings as &$program) {
            $minutes = 0;
            if($program){
                if ($program->sessions) {
                    foreach ($program->sessions as $session) {
                        $start = Carbon::createFromTimeString($session->session_start_time);
                        $end = Carbon::createFromTimeString($session->session_end_time);

                        $adjustedEnd = $end->copy();
                        if ($adjustedEnd->lessThanOrEqualTo($start)) {
                            $adjustedEnd->addDay();
                        }

                        $diff = $adjustedEnd->diffInMinutes($start, true);
                        $minutes += $diff;
                    }
                }
                $program->total_duration_hours = round($minutes / 60, 2);
            }

            $item['program'] = $program;
        }



        $scheduledTrainings       = array_filter($scheduledTrainings);
        $scheduledOrgTrainings    = array_filter($scheduledOrgTrainings);
        $pausedTrainings          = array_filter($pausedTrainings);
        $pausedOrgTrainings       = array_filter($pausedOrgTrainings);
        $ongoingTrainings         = array_filter($ongoingTrainings);
        $ongoingOrgTrainings      = array_filter($ongoingOrgTrainings);
        $completedTrainings       = array_filter($completedTrainings);
        $completedOrgTrainings    = array_filter($completedOrgTrainings);

        return view('user.trainee.myTrainings', compact(
            'scheduledTrainings',
            'scheduledOrgTrainings',
            'pausedTrainings',
            'pausedOrgTrainings',
            'ongoingTrainings',
            'ongoingOrgTrainings',
            'completedTrainings',
            'completedOrgTrainings'
        ));
    }
}
