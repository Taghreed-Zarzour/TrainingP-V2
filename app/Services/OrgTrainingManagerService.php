<?php

namespace App\Services;

use App\Models\OrgTrainingProgram;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrgTrainingManagerService
{
    public function categorizePrograms()
{
    $organizationId = Auth::id();

    // Retrieve active (online) and stopped training programs
    $activePrograms = OrgTrainingProgram::with([
        'goals', 'details', 'assistants',
        'assistantUsers', 'registrationRequirements',
    ])
    ->where('organization_id', $organizationId)
    ->where('status', 'online')
    ->get();

    $stoppedPrograms = OrgTrainingProgram::with([
        'goals', 'details', 'assistants',
        'assistantUsers', 'registrationRequirements',
    ])
    ->where('organization_id', $organizationId)
    ->where('status', 'offline')
    ->get();

    $draft = [];
    $announced = [];
    $ongoing = [];
    $completed = [];
    $stopped = [];
  $now = now();

foreach ($activePrograms as $program) {
    $program->completion_percentage = $this->calculateCompletion($program);

    $applicationDeadline = $program->registrationRequirements->application_deadline ?? null;
    $deadlineDate = $applicationDeadline ? Carbon::parse($applicationDeadline) : null;

    $hasSessions = $program->details && $program->details->some(function ($detail) {
        return $detail->trainingSchedules && $detail->trainingSchedules->count() > 0;
    });

    // مسودة
    if ($program->completion_percentage < 100) {
        $draft[] = $program;
        continue;
    }

    // معلن
    if ($program->completion_percentage === 100 && $deadlineDate && $deadlineDate->isFuture()) {
        $announced[] = $program;
        continue;
    }

    // جارية
    if ($program->completion_percentage === 100 && $hasSessions && $deadlineDate && $deadlineDate->isPast()) {
        foreach ($program->details as $detail) {
            $firstSession = $detail->trainingSchedules->sortBy('session_date')->first();
            $lastSession = $detail->trainingSchedules->sortByDesc('session_date')->first();

            if ($firstSession && $lastSession) {
                $startTime = Carbon::parse($firstSession->session_date . ' ' . $firstSession->session_start_time);
                $endTime = Carbon::parse($lastSession->session_date . ' ' . $lastSession->session_end_time);

                if ($now->between($startTime, $endTime)) {
                    $ongoing[] = $program;
                    continue 2;
                }
            }
        }
    }

    // مكتمل
    if ($program->completion_percentage === 100 && $hasSessions && $deadlineDate && $deadlineDate->isPast()) {
        foreach ($program->details as $detail) {
            $lastSession = $detail->trainingSchedules->sortByDesc('session_date')->first();
            if ($lastSession) {
                $endTime = Carbon::parse($lastSession->session_date . ' ' . $lastSession->session_end_time);
                if ($now->greaterThan($endTime)) {
                    $completed[] = $program;
                    continue 2;
                }
            }
        }
    }

    $draft[] = $program;
}
    // Process stopped training programs
    foreach ($stoppedPrograms as $program) {
        // Calculate completion percentage
        $program->completion_percentage = $this->calculateCompletion($program);

        // Calculate total session duration
        $totalMinutes = 0;
        if ($program->details) {
            foreach ($program->details as $detail) {
                if ($detail->trainingSchedules) {
                    foreach ($detail->trainingSchedules as $session) {
                        try {
                            $startParts = explode(':', $session->session_start_time);
                            $endParts = explode(':', $session->session_end_time);
                            if (count($startParts) >= 2 && count($endParts) >= 2) {
                                $startInMinutes = ((int)$startParts[0] * 60) + (int)$startParts[1];
                                $endInMinutes = ((int)$endParts[0] * 60) + (int)$endParts[1];
                                $diff = max(0, $endInMinutes - $startInMinutes);
                                $totalMinutes += $diff;
                            }
                        } catch (\Exception $e) {
                            continue;
                        }
                    }
                }
            }
        }
        $program->total_session_duration_minutes = $totalMinutes;

        // Check for sessions
        $hasSessions = false;

        if ($program->details) {
            foreach ($program->details as $detail) {
                if ($detail->trainingSchedules && $detail->trainingSchedules->count() > 0) {
                    $hasSessions = true;
                    break; // Exit the loop once we find a match
                }
            }
        }

        // Only completed programs are considered stopped
        if ($program->completion_percentage === 100) {
            $stopped[] = $program;
        } else {
            $draft[] = $program;
        }
    }

    return compact('draft', 'announced', 'ongoing', 'completed', 'stopped');
}

public function calculateCompletion(OrgTrainingProgram $program)
{
    $weights = [
        'basic_info' => 7,
        'details'    => 2,
        'settings'   => 7,
        'goals'      => 6,
    ];

    $totalWeight = array_sum($weights);
    $completedWeight = 0;

    // 1. basic_info
    if (!empty($program->title)) {
        $completedWeight += $weights['basic_info'];
    }

    // 2. details
    if ($program->details && $program->details->count() > 0) {
        $hasProgramTitle = $program->details->contains(function ($detail) {
            return !empty($detail->program_title);
        });
        if ($hasProgramTitle) {
            $completedWeight += $weights['details'];
        }
    }

    // 3. settings
    if ($program->registrationRequirements && 
        !empty($program->registrationRequirements->application_deadline)) {
        $completedWeight += $weights['settings'];
    }

    // 4. goals
    if ($program->goals && $program->goals->count() > 0) {
        $hasLearningOutcomes = $program->goals->contains(function ($goal) {
            return !empty($goal->learning_outcomes);
        });
        if ($hasLearningOutcomes) {
            $completedWeight += $weights['goals'];
        }
    }

    return intval(($completedWeight / $totalWeight) * 100);
}

    public function stopSharing($id){
        $program = OrgTrainingProgram::findOrFail($id);
        $program->status = 'offline';
        $program->save();
    }
    
    public function rePublish($id){
        $program = OrgTrainingProgram::findOrFail($id);
        $program->status = 'online';
        $program->save();
    }
    public function displayStoppedTraining(){
        $organizationId = Auth::id();
        return OrgTrainingProgram::with([
            'goals', 'details', 'assistants',
            'assistantUsers', 'registrationRequirements',   
            ])
            ->where('organization_id', $organizationId)
            ->where('status','offline');
    }
    public function getProgramWithDetails($id)
    {
        $organizationId = Auth::id();
        return OrgTrainingProgram::with([
            'goals', 'details', 'assistants',
            'assistantUsers', 'registrationRequirements',
        ])->where('organization_id', $organizationId)->findOrFail($id);
    }
    
    public function deleteProgram($id)
    {
        $organizationId = Auth::id();
        $program = OrgTrainingProgram::where('organization_id', $organizationId)->findOrFail($id);
        $program->trainingSchedules()->delete();
        $program->details()->delete();
        $program->assistants()->delete();
        $program->assistantUsers()->delete();
        $program->registrationRequirements()->delete();
        $program->goals()->delete();
        $program->delete();
    }
}
