<?php
namespace App\Http\Controllers\Trainings;

use App\Enums\TrainingAttendanceType;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\programType;
use App\Models\trainingAssistantManagement;
use App\Models\TrainingClassification;
use App\Models\trainingLevel;
use App\Models\User;
use App\Models\TrainingProgram;
use App\Services\TrainingAnnouncementService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Enrollment;

class TrainingsController extends Controller
{
    protected $trainingAnnouncementService;
    
    public function __construct(TrainingAnnouncementService $trainingAnnouncementService)
    {
        $this->trainingAnnouncementService = $trainingAnnouncementService;
    }

    public function index()
    {
        $programsResponse = $this->trainingAnnouncementService->index();
        $programs = $programsResponse['data'] ?? [];
        
        // حساب المدة الإجمالية لكل برنامج
        foreach ($programs as $program) {
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
        }
        
        $program_classification = TrainingClassification::all(); // مجال التدريب للفلترة
        $trainerIds = TrainingProgram::pluck('user_id');
        $trainers = User::with('trainee')->whereIn('id', $trainerIds)->get();
        
        return view('trainingAnnouncement.index', compact('programs', 'trainers','program_classification'));
    }

    public function show($id){
        $program = $this->trainingAnnouncementService->getById($id);
        
        // التحقق من وجود البرنامج
        if (!$program) {
            return redirect()->route('trainings.index')->with('error', 'التدريب المطلوب غير موجود');
        }
        
        // حساب الوقت المتبقي للتسجيل
        $now = Carbon::now();
        $remaining = "غير محدد";
        
        if ($program->AdditionalSetting && $program->AdditionalSetting->application_deadline) {
            $deadline = Carbon::parse($program->AdditionalSetting->application_deadline);
            $diffInMinutes = $deadline->diffInMinutes($now, true);
            
            if ($diffInMinutes > 0) {
                $days = floor($diffInMinutes / (60 * 24));
                $hours = floor(($diffInMinutes % (60 * 24)) / 60);
                $remaining = "{$days} يوم، {$hours} ساعة ";
            } else {
                $remaining = "انتهت فترة التسجيل";
            }
        }
        
        // حساب جدول الجلسات
        $session_day = [];
        $session_duration = [];
        $date_display = [];
        
        if ($program->sessions) {
            foreach ($program->sessions as $session) {
                $start = Carbon::createFromTimeString($session->session_start_time);
                $end = Carbon::createFromTimeString($session->session_end_time);
                $adjustedEnd = $end->copy();
                if ($adjustedEnd->lessThanOrEqualTo($start)) {
                    $adjustedEnd->addDay();
                }
                $diff = $adjustedEnd->diffInMinutes($start, true);
                $session_day[] = Carbon::parse($session->session_date)->translatedFormat('l');
                $session_duration[] = round($diff / 60, 2);
                $date_display[] = Carbon::parse($session->session_date)->translatedFormat('d F');
            }
        }
        
        // الحصول على بيانات المدرب
        $trainer = null;
        if ($program->user_id) {
            $trainer = User::find($program->user_id);
        }
        
        // الحصول على المساعدين
        $assistantUsers = collect();
        if ($program->id) {
            $assistantLinks = TrainingAssistantManagement::where('training_program_id', $program->id)->with('assistant')->get();
            $assistantUsers = $assistantLinks->pluck('assistant')->filter();
        }
        
        // التحقق من تسجيل المستخدم
        $has_enrolled = false;
        $enrollment = null;
        if (auth()->check()) {
            $has_enrolled = Enrollment::where('trainee_id', auth()->id())
                ->where('training_programs_id', $id)
                ->exists();
                
            $enrollment = Enrollment::where('trainee_id', auth()->id())
                ->where('training_programs_id', $id)
                ->first();
        }
        
        // حساب تقييم المدرب
        $averageTrainerRating = 0;
        if ($trainer && $trainer->trainer && $trainer->trainer->ratings) {
            $ratings = $trainer->trainer->ratings;
            $criteria = ['clarity', 'interaction', 'organization'];
            $totalRatings = 0;
            $totalSum = 0;
            
            foreach ($ratings as $rating) {
                foreach ($criteria as $criterion) {
                    if (isset($rating->$criterion)) {
                        $score = $rating->$criterion;
                        $totalSum += $score;
                        $totalRatings++;
                    }
                }
            }
            
            $averageTrainerRating = $totalRatings > 0 ? round($totalSum / $totalRatings, 1) : 0;
        }
        
        return view('trainingAnnouncement.show',compact('program','trainer','remaining','session_day','session_duration',
        'date_display','assistantUsers', 'has_enrolled','enrollment','averageTrainerRating'));
    }
}