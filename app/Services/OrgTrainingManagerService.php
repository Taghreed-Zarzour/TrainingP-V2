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
    ->where('status', 'stopped')
    ->get();

    $draft = [];
    $announced = [];
    $ongoing = [];
    $completed = [];
    $stopped = [];
    $now = now();

    // Process active training programs
    foreach ($activePrograms as $program) {
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
        $hasSessions = $program->details && $program->details->some(function ($detail) {
            return $detail->trainingSchedules && $detail->trainingSchedules->count() > 0;
        });

        // Categorize programs
        if ($program->completion_percentage < 100) {
            $draft[] = $program;
            continue;
        }

        if ($program->completion_percentage === 100) {
            if (!$hasSessions || ($program->registrationRequirements && $program->registrationRequirements->schedule_later)) {
                $announced[] = $program;
                continue;
            }

            foreach ($program->details as $detail) {
                $firstSession = $detail->trainingSchedules->sortBy('session_date')->first();
                if ($firstSession) {
                    $startTime = Carbon::parse($firstSession->session_date . ' ' . $firstSession->session_start_time);
                    if ($startTime->isFuture()) {
                        $announced[] = $program;
                        continue 2; // Continue to the next program
                    }
                }
            }
        }

        if ($program->completion_percentage === 100 && $hasSessions) {
            foreach ($program->details as $detail) {
                $firstSession = $detail->trainingSchedules->sortBy('session_date')->first();
                $lastSession = $detail->trainingSchedules->sortByDesc('session_date')->first();

                if ($firstSession && $lastSession) {
                    try {
                        $startTime = Carbon::parse($firstSession->session_date . ' ' . $firstSession->session_start_time);
                        $endTime = Carbon::parse($lastSession->session_date . ' ' . $lastSession->session_end_time);

                        if ($now->between($startTime, $endTime)) {
                            $ongoing[] = $program;
                            continue 2; // Continue to the next program
                        }
                    } catch (\Exception $e) {
                        $draft[] = $program;
                        continue 2; // Continue to the next program
                    }
                }
            }
        }

        if ($program->completion_percentage === 100 && $hasSessions) {
            foreach ($program->details as $detail) {
                $lastSession = $detail->trainingSchedules->sortByDesc('session_date')->first();
                if ($lastSession) {
                    try {
                        $endTime = Carbon::parse($lastSession->session_date . ' ' . $lastSession->session_end_time);
                        if ($now->greaterThan($endTime)) {
                            $completed[] = $program;
                            continue 2; // Continue to the next program
                        }
                    } catch (\Exception $e) {
                        $draft[] = $program;
                        continue 2; // Continue to the next program
                    }
                }
            }
        }

        // Default to draft if no category matched
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
        $hasSessions = $program->details && array_reduce($program->details, function ($carry, $detail) {
            return $carry || ($detail->trainingSchedules && $detail->trainingSchedules->count() > 0);
        }, false);

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
    // Define weights for each step of training creation
    $weights = [
        'basic_info' => 10,
        'details' => 2,
        'settings' => 8,
        'sessions' => 3,
        'goals' => 6,
    ];

    $totalWeight = array_sum($weights);
    $completedWeight = 0;

    // 1. Check basic information
    $basicFields = [
        'title', 'language_id', 'country_id',
        'city', 'address_in_detail', 'training_level_id',
        'program_type', 'program_presentation_method',
        'program_description', 'org_training_classification_id'
    ];

    $basicCompleted = 0;
    foreach ($basicFields as $field) {
        if (!empty($program->$field)) {
            $basicCompleted++;
        }
    }

    $basicPercentage = ($basicCompleted / count($basicFields)) * 100;
    if ($basicPercentage >= 80) {
        $completedWeight += $weights['basic_info'];
    } else {
        $completedWeight += ($basicPercentage / 100) * $weights['basic_info'];
    }

    if ($program->details && $program->details->count() > 0) {
        $detailFields = ['program_title', 'trainer_id'];
        $detailCompleted = 0;
    
        foreach ($program->details as $detail) {
            foreach ($detailFields as $field) {
                if (!empty($detail->$field)) {
                    $detailCompleted++;
                }
            }
        }
    
        // Calculate the percentage based on the number of details
        $detailPercentage = ($detailCompleted / (count($detailFields) * $program->details->count())) * 100;
        $completedWeight += ($detailPercentage / 100) * $weights['details'];

    }

    // 3. Check settings
    if ($program->registrationRequirements) {
        $settingFields = [
            'is_free', 'application_deadline', 'max_trainees',
            'application_submission_method', 'requirements',
            'benefits', 'training_image', 'welcome_message'
        ];

        $settingCompleted = 0;
        foreach ($settingFields as $field) {
            if (!empty($program->registrationRequirements->$field)) {
                $settingCompleted++;
            }
        }

        // Check if the training is paid
        if (!$program->registrationRequirements->is_free) {
            if (!empty($program->registrationRequirements->cost) && !empty($program->registrationRequirements->currency)) {
                $settingCompleted++;
            }
        }

        $settingPercentage = ($settingCompleted / count($settingFields)) * 100;
        $completedWeight += ($settingPercentage / 100) * $weights['settings'];

    }

    // 4. Check sessions
    if ($program->details && $program->details->count() > 0) {
        $validSessions = 0;
        foreach ($program->details as $detail) {
            if ($detail->trainingSchedules && $detail->trainingSchedules->count() > 0) {
                foreach ($detail->trainingSchedules as $session) {
                    if (!empty($session->session_date) && 
                        !empty($session->session_start_time) && 
                        !empty($session->session_end_time)) {
                        $validSessions++;
                    }
                }
            }
        }
        $sessionsPercentage = ($validSessions / ($program->details->sum(function ($detail) {
            return $detail->trainingSchedules->count();
        }))) * 100;
        $completedWeight += ($sessionsPercentage / 100) * $weights['sessions'];
    } else {
        $completedWeight += $weights['sessions'];
    }


    // 5. Check goals
    // Check goals
if ($program->goals && $program->goals->count() > 0) {
    $goalFields = ['learning_outcomes', 'education_level_id', 'work_status',
                   'work_sector_id', 'job_position', 'country_id'];
    $goalCompleted = 0;
    
    // Iterate through each goal
    foreach ($program->goals as $goal) {
        $completedFields = 0;

        // Check each field for the current goal
        foreach ($goalFields as $field) {
            if (!empty($goal->$field)) {
                $completedFields++;
            }
        }

        // Calculate completion for this goal
        $goalPercentage = ($completedFields / count($goalFields)) * 100;
        $goalCompleted += $goalPercentage; // Accumulate the percentage
    }

    // Average the goal completion percentage across all goals
    $averageGoalPercentage = $goalCompleted / $program->goals->count();
    $completedWeight += ($averageGoalPercentage / 100) * $weights['goals'];


    } else {
        // If goals are not set, consider them incomplete
        $completedWeight += 0; // Or add the full weight if desired
    }

    $overallPercentage = ($completedWeight / $totalWeight) * 100;
    return intval($overallPercentage);
}

    public function stopSharing($id){
        $program = OrgTrainingProgram::findOrFail($id);
        $program->status = 'stopped';
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
            ->where('status','stopped');
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
