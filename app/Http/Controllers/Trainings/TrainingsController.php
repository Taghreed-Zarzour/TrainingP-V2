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
use App\Models\OrgTrainingProgram;

class TrainingsController extends Controller
{
    protected $trainingAnnouncementService;

    public function __construct(TrainingAnnouncementService $trainingAnnouncementService)
    {
        $this->trainingAnnouncementService = $trainingAnnouncementService;
    }

    // دالة مساعدة للجمع العربي
    private function arabicPlural($number, $word)
{
    $forms = [
        'يوم'   => ['يوم', 'يومين', 'أيام'],
        'ساعة'  => ['ساعة', 'ساعتين', 'ساعات'],
        'دقيقة' => ['دقيقة', 'دقيقتين', 'دقائق'],
        'أسبوع' => ['أسبوع', 'أسبوعين', 'أسابيع'],
        'شهر'   => ['شهر', 'شهرين', 'أشهر'],
    ];

    if (!isset($forms[$word])) {
        return $word; // في حال ما وجدنا الكلمة
    }

    if ($number == 1) {
        return $forms[$word][0];
    } elseif ($number == 2) {
        return $forms[$word][1];
    } elseif ($number > 2 && $number <= 10) {
        return $forms[$word][2];
    } else {
        return $forms[$word][0];
    }
}


    // دالة مساعدة لحساب الوقت المتبقي/المنقضي
private function calculateRegistrationStatus($deadline)
{
    $now = Carbon::now();

    if (!$deadline) {
        return [
            'text' => 'تاريخ انتهاء التسجيل غير محدد',
            'status' => 'unknown'
        ];
    }

    $deadline = Carbon::parse($deadline);

    if ($deadline->isFuture()) {
        // الوقت المتبقي
$diffInSeconds = $now->diffInSeconds($deadline);
        $days = (int) floor($diffInSeconds / (60 * 60 * 24));
        $hours = (int) floor(($diffInSeconds % (60 * 60 * 24)) / (60 * 60));

        if ($days > 0) {
            $daysText = $this->arabicPlural($days, 'يوم');
            $hoursText = $this->arabicPlural($hours, 'ساعة');
            return [
                'text' => "متبقي {$days} {$daysText} و{$hours} {$hoursText} على انتهاء التسجيل",
                'status' => 'active'
            ];
        } else {
            $hoursText = $this->arabicPlural($hours, 'ساعة');
            return [
                'text' => "متبقي {$hours} {$hoursText} على انتهاء التسجيل",
                'status' => 'ending_soon'
            ];
        }
    } else {
        // الوقت المنقضي
        $daysAgo = (int) abs($now->diffInDays($deadline));

        if ($daysAgo === 0) {
            return [
                'text' => "انتهت فترة التسجيل اليوم",
                'status' => 'expired'
            ];
        } elseif ($daysAgo === 1) {
            return [
                'text' => "انتهت فترة التسجيل أمس",
                'status' => 'expired'
            ];
        } elseif ($daysAgo <= 7) {
            $daysText = $this->arabicPlural($daysAgo, 'يوم');
            return [
                'text' => "انتهت فترة التسجيل منذ {$daysAgo} {$daysText}",
                'status' => 'expired'
            ];
        } elseif ($daysAgo <= 30) {
            $weeksAgo = (int) floor($daysAgo / 7);
            $weeksText = $this->arabicPlural($weeksAgo, 'أسبوع');
            return [
                'text' => "انتهت فترة التسجيل منذ {$weeksAgo} {$weeksText}",
                'status' => 'expired'
            ];
      } else {
    $monthsAgo = (int) abs($now->diffInMonths($deadline));

    if ($monthsAgo >= 12) {
        $yearsAgo = floor($monthsAgo / 12);
        $remainingMonths = $monthsAgo % 12;

        $yearsText = $this->arabicPlural($yearsAgo, 'سنة');

        if ($remainingMonths > 0) {
            $monthsText = $this->arabicPlural($remainingMonths, 'شهر');
            return [
                'text' => "انتهت فترة التسجيل منذ {$yearsAgo} {$yearsText} و{$remainingMonths} {$monthsText}",
                'status' => 'expired'
            ];
        } else {
            return [
                'text' => "انتهت فترة التسجيل منذ {$yearsAgo} {$yearsText}",
                'status' => 'expired'
            ];
        }
    } else {
        $monthsText = $this->arabicPlural($monthsAgo, 'شهر');
        return [
            'text' => "انتهت فترة التسجيل منذ {$monthsAgo} {$monthsText}",
            'status' => 'expired'
        ];
    }
}

    }
}

public function index()
{
    $programsResponse = $this->trainingAnnouncementService->index();

    $programs = $programsResponse['data'] ?? [];
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

        // حساب حالة التسجيل لكل برنامج
        $deadline = $program->AdditionalSetting->application_deadline ?? null;
        $program->registration_status = $this->calculateRegistrationStatus($deadline);
    }

    $program_classification = TrainingClassification::all();
    $trainerIds = TrainingProgram::pluck('user_id');
    $trainers = User::with('trainee')->whereIn('id', $trainerIds)->get();

    $currentDateTime = now(); // الحصول على الوقت الحالي

    $allOrgPrograms = OrgTrainingProgram::with(
        'details',
        'goals',
        'registrationRequirements',
        'assistants'
    )
    ->where('status', 'online')
    ->get()
    ->filter(function ($program) use ($currentDateTime) {
        // الحصول على التاريخ الحالي
        $currentDate = $currentDateTime->toDateString(); // تحويل الوقت الحالي إلى تاريخ فقط
    
        if ($program->details && $program->details->count() > 0) {
            foreach ($program->details as $detail) {
                if ($detail->trainingSchedules && $detail->trainingSchedules->count() > 0) {
                    $lastSession = $detail->trainingSchedules->last();
                    
                    // استخدام session_date للحصول على تاريخ الجلسة
                    $sessionDate = $lastSession->session_date; // تأكد من أن هذا التاريخ بالتنسيق الصحيح
                    
                    // تحقق مما إذا كانت الجلسة تنتهي بعد التاريخ الحالي
                    return $sessionDate > $currentDate; // استخدم > للتأكد من أن الجلسة بعد اليوم
                }
            }
        }
        return false; // إذا لم يكن هناك تفاصيل أو جلسات، اعتبر البرنامج غير صالح
    });

    return view('trainingAnnouncement.index', compact('programs', 'trainers', 'program_classification', 'allOrgPrograms'));
}
    public function show($id)
    {
        $program = $this->trainingAnnouncementService->getById($id);

        if (!$program) {
            return redirect()->route('trainings.index')->with('error', 'التدريب المطلوب غير موجود');
        }

        // حساب حالة التسجيل
        $deadline = $program->AdditionalSetting->application_deadline ?? null;
        $registrationStatus = $this->calculateRegistrationStatus($deadline);
        $remainingText = $registrationStatus['text'];


            // تحديد ما إذا انتهى موعد التسجيل
    $training_has_ended = false;
    if ($deadline) {
        $training_has_ended = now() > Carbon::parse($deadline);
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
            $assistantLinks = TrainingAssistantManagement::where('training_program_id', $program->id)
                ->with('assistant')
                ->get();
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

        return view('trainingAnnouncement.show', compact(
            'program',
            'trainer',
            'remainingText',
            'session_day',
            'session_duration',
            'date_display',
            'assistantUsers',
            'has_enrolled',
            'enrollment',
            'averageTrainerRating',
            'registrationStatus',
             'training_has_ended',
        ));
    }
}