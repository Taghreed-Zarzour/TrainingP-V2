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
        
        // جلب التدريبات النشطة (online) والمتوقفة (stopped)
        $activePrograms = OrgTrainingProgram::with([
            'organization', 'goals', 'details', 'assistants'
            ,'assistantUsers','registrationRequirements','language','trainingClassification',
            'trainingLevel','programType','country','files','trainingSchedules'
            ])
            ->where('organization_id', $organizationId)
            ->where('status', 'online') 
            ->get();
            
        $stoppedPrograms = OrgTrainingProgram::with([
            'organization', 'goals', 'details', 'assistants',
            'assistantUsers','registrationRequirements','language','trainingClassification',
            'trainingLevel','programType','country','files','trainingSchedules'
        ])
            ->where('user_id', $organizationId)
            ->where('status', 'stopped') 
            ->get();
            
        $draft = [];
        $announced = [];
        $ongoing = [];
        $completed = [];
        $stopped = [];
        $now = now();
        
        // معالجة التدريبات النشطة
        foreach ($activePrograms as $program) {
            // حساب نسبة الإكمال
            $program->completion_percentage = $this->calculateCompletion($program);
            
            // حساب الوقت الكلي للجلسات
            $totalMinutes = 0;
            foreach ($program->sessions as $session) {
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
            $program->total_session_duration_minutes = $totalMinutes;
            
            // التحقق من وجود جلسات
            $hasSessions = $program->sessions && $program->sessions->count() > 0;
            
            // 1. التدريبات قيد الإنشاء (غير مكتملة)
            if ($program->completion_percentage < 100) {
                $draft[] = $program;
                continue;
            }
            
            // 2. التدريبات المعلنة (مكتملة 100% ولم تبدأ بعد)
            if ($program->completion_percentage === 100) {
                // إذا لم تكن هناك جلسات أو تم اختيار تحديد الجلسات لاحقاً، فهي معلنة
                if (!$hasSessions || ($program->AdditionalSetting && $program->AdditionalSetting->schedule_later)) {
                    $announced[] = $program;
                    continue;
                }
                
                // إذا كانت هناك جلسات، تحقق من تاريخ أول جلسة
                $firstSession = $program->sessions->sortBy('session_date')->first();
                if ($firstSession) {
                    $startTime = Carbon::parse($firstSession->session_date . ' ' . $firstSession->session_start_time);
                    if ($startTime->isFuture()) {
                        $announced[] = $program;
                        continue;
                    }
                }
            }
            
            // 3. التدريبات الجارية (مكتملة 100% والجلسات بدأت ولم تنتهِ)
            if ($program->completion_percentage === 100 && $hasSessions) {
                $firstSession = $program->sessions->sortBy('session_date')->first();
                $lastSession = $program->sessions->sortByDesc('session_date')->first();
                
                if ($firstSession && $lastSession) {
                    try {
                        $startTime = Carbon::parse($firstSession->session_date . ' ' . $firstSession->session_start_time);
                        $endTime = Carbon::parse($lastSession->session_date . ' ' . $lastSession->session_end_time);
                        
                        if ($now->between($startTime, $endTime)) {
                            $ongoing[] = $program;
                            continue;
                        }
                    } catch (\Exception $e) {
                        $draft[] = $program;
                        continue;
                    }
                }
            }
            
            // 4. التدريبات المكتملة (مكتملة 100% وانتهت جميع الجلسات)
            if ($program->completion_percentage === 100 && $hasSessions) {
                $lastSession = $program->sessions->sortByDesc('session_date')->first();
                if ($lastSession) {
                    try {
                        $endTime = Carbon::parse($lastSession->session_date . ' ' . $lastSession->session_end_time);
                        if ($now->greaterThan($endTime)) {
                            $completed[] = $program;
                            continue;
                        }
                    } catch (\Exception $e) {
                        $draft[] = $program;
                        continue;
                    }
                }
            }
            
            // لأي حالة ما انصنفت، نحطها بالمسودات كخيار آمن
            $draft[] = $program;
        }
        
        // معالجة التدريبات المتوقفة
        foreach ($stoppedPrograms as $program) {
            // حساب نسبة الإكمال
            $program->completion_percentage = $this->calculateCompletion($program);
            
            // حساب الوقت الكلي للجلسات
            $totalMinutes = 0;
            foreach ($program->sessions as $session) {
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
            $program->total_session_duration_minutes = $totalMinutes;
            
            // التحقق من وجود جلسات
            $hasSessions = $program->sessions && $program->sessions->count() > 0;
            
            // فقط التدريبات المكتملة 100% تعتبر متوقفة عن الإعلان
            if ($program->completion_percentage === 100) {
                $stopped[] = $program;
            } else {
                $draft[] = $program;
            }
        }
        
        return compact('draft', 'announced', 'ongoing', 'completed', 'stopped');
    }
    
    // حساب نسبة اكتمال التدريب بشكل احترافي
    public function calculateCompletion(OrgTrainingProgram $program)
    {
        // تعريف أوزان لكل خطوة من خطوات إنشاء التدريب (تم تعديل الأوزان)
        $weights = [
            'basic_info' => 9,      // المعلومات الأساسية (الاسم، الوصف، إلخ) — قللنا الوزن
            'details' => 2,         // التفاصيل (المخرجات، المتطلبات، الفئة المستهدفة، المزايا) — زدنا الوزن
            'settings' => 8,        // الإعدادات (السعر، الموعد النهائي، الحد الأقصى للمتدربين، إلخ) — زدنا الوزن
            'sessions' => 0,        // الجلسات — زدنا الوزن
            'goals' => 6,
        ];
        
        $totalWeight = array_sum($weights);
        $completedWeight = 0;
        
        // 1. التحقق من المعلومات الأساسية
        $basicFields = [
            'title', 'language_id', 'country',
            'city', 'address_in_detail','training_level_id',
            'program_type', 'program_presentation_method_id',
            'program_description'
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
        
        // 2. التحقق من التفاصيل
        if ($program->details) {
            $detailFields = ['program_title', 'trainer_id'];
            $detailCompleted = 0;
            
            foreach ($detailFields as $field) {
                if (!empty($program->details->$field)) {
                    $detailCompleted++;
                }
            }
            
            $detailPercentage = ($detailCompleted / count($detailFields)) * 100;
            $completedWeight += ($detailPercentage / 100) * $weights['details'];
        }
        
        // 3. التحقق من الإعدادات
        if ($program->registrationRequirements) {
            $settingFields = [
                'is_free', 'application_deadline', 'max_trainees',
                'application_submission_method','requirements',
                'benefits','training_image','welcome_message'
            ];
            
            $settingCompleted = 0;
            foreach ($settingFields as $field) {
                if (!empty($program->registrationRequirements->$field)) {
                    $settingCompleted++;
                }
            }
            
            // إذا كان التدريب مدفوعاً، يجب تحديد السعر والعملة
            if (!$program->registrationRequirements->is_free) {
                if (!empty($program->registrationRequirements->cost) && !empty($program->registrationRequirements->currency)) {
                    $settingCompleted++;
                }
            }
            
            $settingPercentage = ($settingCompleted / count($settingFields)) * 100;
            $completedWeight += ($settingPercentage / 100) * $weights['settings'];
        }
        
        // 4. التحقق من الجلسات
        if ($program->details->trainingSchedules && $program->details->trainingSchedules->count() > 0) {
            $validSessions = 0;
            foreach ($program->details->trainingSchedules as $session) {
                if (!empty($session->session_date) && 
                    !empty($session->session_start_time) && 
                    !empty($session->session_end_time)) {
                    $validSessions++;
                }
            }
            
            $sessionsPercentage = ($validSessions / $program->sessions->count()) * 100;
            $completedWeight += ($sessionsPercentage / 100) * $weights['sessions'];
        } else {
            $completedWeight += $weights['sessions'];
        }

        if ($program->goals) {
            $goalFields = ['learning_outcomes', 'education_level', 'work_status',
                            'work_sector_id','job_position','country_id'
                        ];
            $goalCompleted = 0;
        
            foreach ($goalFields as $field) {
                if (!empty($program->goals->$field)) {
                    $goalCompleted++;
                }
            }
        
            $goalPercentage = ($goalCompleted / count($goalFields)) * 100;
            $completedWeight += ($goalPercentage / 100) * $weights['goals'];
        } else {
            // إذا لم يتم تحديد الأهداف، يمكن اعتبارها غير مكتملة
            $completedWeight += 0; // أو يمكنك إضافة الوزن الكامل إذا كنت تفضل ذلك
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
            'organization', 'goals', 'details', 'assistants'
            ,'assistantUsers','registrationRequirements','language','trainingClassification',
            'trainingLevel','programType','country','files' ,'trainingSchedules'
            ])
            ->where('organization_id', $organizationId)
            ->where('status','stopped');
    }
    public function getProgramWithDetails($id)
    {
        $organizationId = Auth::id();
        return OrgTrainingProgram::with([
            'organization', 'goals', 'details', 'assistants'
            ,'assistantUsers','registrationRequirements','language','trainingClassification',
            'trainingLevel','programType','country','files','trainingSchedules'
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
