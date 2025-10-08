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
            ->orWhere('status', 'offline')
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
public function calculateCompletion(TrainingProgram $program)
{
    // تعريف أوزان لكل خطوة من خطوات إنشاء التدريب (مجموعها = 100)
    $weights = [
        'basic_info' => 25,   // المعلومات الأساسية
        'details' => 25,      // التفاصيل
        'settings' => 25,     // الإعدادات
        'additional_check' => 25, // أي خطوة إضافية أو اختيارية
    ];

    $totalWeight = array_sum($weights);
    $completedWeight = 0;

    // 1. المعلومات الأساسية (سؤال واحد)
    $basicCompleted = !empty($program->title) ? 1 : 0;
    $completedWeight += ($basicCompleted / 1) * $weights['basic_info'];

    // 2. التفاصيل (سؤال واحد)
    $detailCompleted = ($program->detail && !empty($program->detail->learning_outcomes)) ? 1 : 0;
    $completedWeight += ($detailCompleted / 1) * $weights['details'];

    // 3. الإعدادات (سؤال واحد فقط)
    $settingCompleted = ($program->AdditionalSetting && !empty($program->AdditionalSetting->application_deadline)) ? 1 : 0;
    $completedWeight += ($settingCompleted / 1) * $weights['settings'];

    // 4. خطوة إضافية اختيارية (مثلاً أي شيء آخر تريد التحقق منه، هنا نفترض 1 سؤال)
    // إذا ما فيه شيء إضافي يمكن تجاهلها أو اعطاءها صفر
    $additionalCompleted = 1; // نفترض مكتمل لتبسيط، أو يمكن تعديل حسب الحاجة
    $completedWeight += ($additionalCompleted / 1) * $weights['additional_check'];

    // النسبة الإجمالية، مع التأكد أنها لا تتجاوز 100
    $overallPercentage = min(($completedWeight / $totalWeight) * 100, 100);

    return intval($overallPercentage);
}


    
    // بقية الكود كما هو (جلب، حذف، إيقاف، إعادة نشر)
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
