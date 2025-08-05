<?php
namespace App\Services;
use App\Models\TrainingProgram;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class TrainingProgramServices
{
    public function categorizePrograms()
    {
        $userId = Auth::id();
        
        // جلب التدريبات النشطة (online) والمتوقفة (stopped)
        $activePrograms = TrainingProgram::with(['detail', 'AdditionalSetting', 'sessions', 'trainees'])
            ->where('user_id', $userId)
            ->where('status', 'online') 
            ->get();
            
        $stoppedPrograms = TrainingProgram::with(['detail', 'AdditionalSetting', 'sessions', 'trainees'])
            ->where('user_id', $userId)
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
                        // في حال فشل التحويل لأي سبب
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
                        // في حال فشل التحويل لأي سبب
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
                // إذا لم تكن مكتملة، ضعها في المسودات
                $draft[] = $program;
            }
        }
        
        return compact('draft', 'announced', 'ongoing', 'completed', 'stopped');
    }
    
    // حساب نسبة اكتمال التدريب بشكل احترافي
    public function calculateCompletion(TrainingProgram $program)
    {
        // تعريف أوزان لكل خطوة من خطوات إنشاء التدريب
        $weights = [
            'basic_info' => 25,      // المعلومات الأساسية (الاسم، الوصف، إلخ)
            'details' => 20,         // التفاصيل (المخرجات، المتطلبات، الفئة المستهدفة، المزايا)
            'settings' => 30,        // الإعدادات (السعر، الموعد النهائي، الحد الأقصى للمتدربين، إلخ)
            'sessions' => 25,        // الجلسات
        ];
        
        $totalWeight = array_sum($weights);
        $completedWeight = 0;
        
        // 1. التحقق من المعلومات الأساسية
        $basicFields = [
            'title', 'description', 'program_type_id',
            'language_type_id', 'training_classification_id',
            'training_level_id', 'program_presentation_method_id',
        ];
        
        $basicCompleted = 0;
        foreach ($basicFields as $field) {
            if (!empty($program->$field)) {
                $basicCompleted++;
            }
        }
        
        $basicPercentage = ($basicCompleted / count($basicFields)) * 100;
        if ($basicPercentage >= 80) { // نعتبر المعلومات الأساسية مكتملة إذا تم تعبئة 80% منها على الأقل
            $completedWeight += $weights['basic_info'];
        } else {
            $completedWeight += ($basicPercentage / 100) * $weights['basic_info'];
        }
        
        // 2. التحقق من التفاصيل
        if ($program->detail) {
            $detailFields = ['learning_outcomes', 'requirements', 'target_audience', 'benefits'];
            $detailCompleted = 0;
            
            foreach ($detailFields as $field) {
                if (!empty($program->detail->$field)) {
                    $detailCompleted++;
                }
            }
            
            $detailPercentage = ($detailCompleted / count($detailFields)) * 100;
            $completedWeight += ($detailPercentage / 100) * $weights['details'];
        }
        
        // 3. التحقق من الإعدادات
        if ($program->AdditionalSetting) {
            $settingFields = [
                'is_free', 'application_deadline', 'max_trainees',
                'application_submission_method'
            ];
            
            $settingCompleted = 0;
            foreach ($settingFields as $field) {
                if (!is_null($program->AdditionalSetting->$field)) {
                    $settingCompleted++;
                }
            }
            
            // إذا كان التدريب مدفوعاً، يجب تحديد السعر والعملة
            if (!$program->AdditionalSetting->is_free) {
                if (!empty($program->AdditionalSetting->cost) && !empty($program->AdditionalSetting->currency)) {
                    $settingCompleted++;
                }
            }
            
            $settingPercentage = ($settingCompleted / count($settingFields)) * 100;
            $completedWeight += ($settingPercentage / 100) * $weights['settings'];
        }
        
        // 4. التحقق من الجلسات
        if ($program->sessions && $program->sessions->count() > 0) {
            // نتحقق من أن كل جلسة لها تاريخ ووقت بداية ونهاية
            $validSessions = 0;
            foreach ($program->sessions as $session) {
                if (!empty($session->session_date) && 
                    !empty($session->session_start_time) && 
                    !empty($session->session_end_time)) {
                    $validSessions++;
                }
            }
            
            $sessionsPercentage = ($validSessions / $program->sessions->count()) * 100;
            $completedWeight += ($sessionsPercentage / 100) * $weights['sessions'];
        } else if ($program->AdditionalSetting && $program->AdditionalSetting->schedule_later) {
            // إذا تم اختيار تحديد الجلسات لاحقاً، نعتبر هذا الجزء مكتمل
            $completedWeight += $weights['sessions'];
        }
        
        // حساب النسبة الإجمالية
        $overallPercentage = ($completedWeight / $totalWeight) * 100;
        
        return intval($overallPercentage);
    }
    
    // جلب برنامج تدريب مع جميع التفاصيل المرتبطة به
    public function getProgramWithDetails($id)
    {
        $userId = Auth::id();
        return TrainingProgram::with([
            'detail',
            'AdditionalSetting',
            'sessions',
            'assistants'
        ])->where('user_id', $userId)->findOrFail($id);
    }
    
    // حذف برنامج كامل مع جميع البيانات المرتبطة
    public function deleteProgram($id)
    {
        $userId = Auth::id();
        $program = TrainingProgram::where('user_id', $userId)->findOrFail($id);
        $program->detail()->delete();
        $program->AdditionalSetting()->delete();
        $program->sessions()->delete();
        $program->delete();
    }
    
    public function stopSharing($id){
        $program = TrainingProgram::findOrFail($id);
        $program->status = 'stopped';
        $program->save();
    }
    
    public function rePublish($id){
        $program = TrainingProgram::findOrFail($id);
        $program->status = 'online';
        $program->save();
    }
    
    public function displayStoppedTraining(){
        $userId = Auth::id();
        return TrainingProgram::with([
            'detail',
            'AdditionalSetting',
            'sessions',
            'assistants'])
            ->where('user_id', $userId)
            ->where('status','stopped');
    }
}