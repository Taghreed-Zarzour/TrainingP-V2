<?php
namespace App\Http\Controllers\User\Trainee;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\OrgTrainingProgram;
use App\Models\TrainingProgram;
use Carbon\Carbon;
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

        dd($enrollments);

        foreach ($enrollments as $enrollment) {
            // ====== الحالة 1: التدريبات المعلقة (stopped) ======
            if ($enrollment->training_programs_id) {
                $training = TrainingProgram::find($enrollment->training_programs_id);
                if ($training && $training->status === 'stopped') {
                    $this->calculateDuration($training);
                    $pausedTrainings[] = $training;
                    continue;
                }
            }
            if ($enrollment->org_training_programs_id) {
                $orgTraining = OrgTrainingProgram::find($enrollment->org_training_programs_id);
                if ($orgTraining && $orgTraining->status === 'stopped') {
                    $pausedOrgTrainings[] = $orgTraining;
                    continue;
                }
            }
            
            // ====== الحالة 2: المتدرب مرفوض أو بانتظار القبول ======
            if (in_array($enrollment->status, ['pending', 'rejected'])) {
                $this->handlePendingOrRejected($enrollment, $scheduledTrainings, $scheduledOrgTrainings);
                continue;
            }
            
            // ====== الحالة 3: المتدرب مقبول ======
            if ($enrollment->status === 'accepted') {
                // --- التدريبات العادية ---
                if ($enrollment->training_programs_id) {
                    $training = TrainingProgram::where('status', 'online')->find($enrollment->training_programs_id);
                    if ($training) {
                        $this->processTraining($training, $scheduledTrainings, $ongoingTrainings, $completedTrainings);
                    }
                }
                
                // --- التدريبات المؤسسية ---
                if ($enrollment->org_training_programs_id) {
                    $orgTraining = OrgTrainingProgram::where('status', 'online')->find($enrollment->org_training_programs_id);
                    if ($orgTraining) {
                        $this->processOrgTraining($orgTraining, $scheduledOrgTrainings, $ongoingOrgTrainings, $completedOrgTrainings);
                    }
                }
            }
        }

        // تنظيف القوائم من العناصر الفارغة
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

    // ====== حساب مدة التدريب ======
    private function calculateDuration($program)
    {
        $minutes = 0;
        if ($program && $program->sessions) {
            foreach ($program->sessions as $session) {
                $start = Carbon::createFromTimeString($session->session_start_time);
                $end = Carbon::createFromTimeString($session->session_end_time);
                $adjustedEnd = $end->copy();
                if ($adjustedEnd->lessThanOrEqualTo($start)) {
                    $adjustedEnd->addDay();
                }
                $minutes += $adjustedEnd->diffInMinutes($start, true);
            }
        }
        $program->total_duration_hours = round($minutes / 60, 2);
    }

    // ====== معالجة التدريبات المرفوضة/المعلقة ======
    private function handlePendingOrRejected($enrollment, &$scheduledTrainings, &$scheduledOrgTrainings)
    {
        if ($enrollment->training_programs_id) {
            $training = TrainingProgram::where('status', 'online')->find($enrollment->training_programs_id);
            if ($training) {
                $this->calculateDuration($training);
                
                // الحصول على أول جلسة
                $firstSession = $training->sessions()->orderBy('session_date')->first();
                $start_date = $firstSession ? $firstSession->session_date : null;
                
                $scheduledTrainings[] = [
                    'program' => $training,
                    'status' => $enrollment->status,
                    'start_date' => $start_date, // إضافة تاريخ أول جلسة
                ];
            }
        }
        if ($enrollment->org_training_programs_id) {
            $orgTraining = OrgTrainingProgram::where('status', 'online')->find($enrollment->org_training_programs_id);
            if ($orgTraining) {
                // الحصول على أول جلسة
                $allSchedules = $orgTraining->details()->with('trainingSchedules')->get()->flatMap->trainingSchedules;
                $firstSession = $allSchedules->sortBy('session_date')->first();
                $start_date = $firstSession ? $firstSession->session_date : null;
                
                $scheduledOrgTrainings[] = [
                    'program' => $orgTraining,
                    'status' => $enrollment->status,
                    'start_date' => $start_date, // إضافة تاريخ أول جلسة
                ];
            }
        }
    }

    // ====== معالجة تدريب عادي ======
    private function processTraining($training, &$scheduled, &$ongoing, &$completed)
    {
        $deadline = Carbon::parse($training->AdditionalSetting->application_deadline);
        $firstSession = $training->sessions()->orderBy('session_date')->first();
        $lastSession = $training->sessions()->orderByDesc('session_date')->first();
        $firstStart = $firstSession
            ? Carbon::parse($firstSession->session_date . ' ' . $firstSession->session_start_time)
            : null;
        $lastEnd = $lastSession
            ? Carbon::parse($lastSession->session_date . ' ' . $lastSession->session_end_time)
            : null;
        
        // حساب نسبة الإكمال
        $totalSessions = $training->sessions()->count();
        $completedSessions = $training->sessions()
            ->where(function($query) {
                $query->where('session_date', '<', now()->toDateString())
                      ->orWhere(function($q) {
                          $q->where('session_date', now()->toDateString())
                            ->where('session_end_time', '<', now()->toTimeString());
                      });
            })
            ->count();
        $completionRate = $totalSessions > 0 ? round(($completedSessions / $totalSessions) * 100, 2) : 0;
        $training->completion_rate = $completionRate;
        
        // الحصول على الجلسة التالية
        $nextSession = $training->sessions()
            ->where(function($query) {
                $query->where('session_date', '>', now()->toDateString())
                      ->orWhere(function($q) {
                          $q->where('session_date', now()->toDateString())
                            ->where('session_end_time', '>=', now()->toTimeString());
                      });
            })
            ->orderBy('session_date')
            ->orderBy('session_start_time')
            ->first();
        
        // التصنيف
        if ($training->AdditionalSetting->schedule_later == 1 || $deadline->isFuture() || ($firstStart && now()->lt($firstStart))) {
            $this->calculateDuration($training);
            
            // إضافة تاريخ أول جلسة
            $start_date = $firstSession ? $firstSession->session_date : null;
            
            $scheduled[] = [
                'program' => $training,
                'status' => 'accepted',
                'completionRate' => $completionRate,
                'start_date' => $start_date, // إضافة تاريخ أول جلسة
            ];
        } elseif ($lastEnd && now()->between($firstStart, $lastEnd)) {
            $this->calculateDuration($training);
            $ongoing[] = [
                'program' => $training,
                'completionRate' => $completionRate,
                'nextSession' => $nextSession
            ];
        } elseif ($lastEnd && now()->gt($lastEnd)) {
            $this->calculateDuration($training);
            $completed[] = [
                'program' => $training,
                'completionRate' => $completionRate
            ];
        }
    }

    // ====== معالجة تدريب مؤسسي ======
    private function processOrgTraining($orgTraining, &$scheduled, &$ongoing, &$completed)
    {
        $deadline = Carbon::parse($orgTraining->registrationRequirements->application_deadline);
        $allSchedules = $orgTraining->details()->with('trainingSchedules')->get()->flatMap->trainingSchedules;
        $firstSession = $allSchedules->sortBy('session_date')->first();
        $lastSession = $allSchedules->sortByDesc('session_date')->first();
        $firstStart = $firstSession
            ? Carbon::parse($firstSession->session_date . ' ' . $firstSession->session_start_time)
            : null;
        $lastEnd = $lastSession
            ? Carbon::parse($lastSession->session_date . ' ' . $lastSession->session_end_time)
            : null;
        
        // حساب نسبة الإكمال
        $totalSessions = $allSchedules->count();
        $completedSessions = $allSchedules->filter(function($session) {
            $sessionEnd = Carbon::parse($session->session_date . ' ' . $session->session_end_time);
            return $sessionEnd->isPast();
        })->count();
        $completionRate = $totalSessions > 0 ? round(($completedSessions / $totalSessions) * 100, 2) : 0;
        $orgTraining->completion_rate = $completionRate;
        
        // الحصول على الجلسة التالية
        $nextSession = $allSchedules
            ->filter(function($session) {
                $sessionEnd = Carbon::parse($session->session_date . ' ' . $session->session_end_time);
                return $sessionEnd->isFuture();
            })
            ->sortBy([
                ['session_date', 'asc'],
                ['session_start_time', 'asc']
            ])
            ->first();
        
        if ($orgTraining->details->first()->schedule_later == 1 || $deadline->isFuture() || ($firstStart && now()->lt($firstStart))) {
            // إضافة تاريخ أول جلسة
            $start_date = $firstSession ? $firstSession->session_date : null;
            
            $scheduled[] = [
                'program' => $orgTraining,
                'status' => 'accepted',
                'completionRate' => $completionRate,
                'start_date' => $start_date, // إضافة تاريخ أول جلسة
            ];
        } elseif ($lastEnd && now()->between($firstStart, $lastEnd)) {
            $ongoing[] = [
                'program' => $orgTraining,
                'completionRate' => $completionRate,
                'nextSession' => $nextSession
            ];
        } elseif ($lastEnd && now()->gt($lastEnd)) {
            $completed[] = [
                'program' => $orgTraining,
                'completionRate' => $completionRate
            ];
        }
    }
}