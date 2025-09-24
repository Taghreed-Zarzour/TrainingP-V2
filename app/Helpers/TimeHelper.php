<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    /**
     * حساب الوقت الكلي للبرنامج التدريبي
     *
     * @param array|\Illuminate\Support\Collection $sessions
     * @param int $schedules_later 1 إذا عدد الساعات معروف مسبقًا، 0 إذا من الجلسات
     * @param float|null $num_of_hours عدد الساعات الكلي إذا schedules_later = 1
     * @param int|null $num_of_session عدد الجلسات
     * @return array ['total_hours' => float, 'duration_text' => string]
     */
    public static function calculateProgramDuration($sessions, $schedules_later = 0, $num_of_hours = null, $num_of_session = null)
    {
        $totalMinutes = 0;

        if ($schedules_later) {
            // الحالة 1: تم تحديد عدد الساعات مسبقاً
            $totalMinutes = ($num_of_hours ?? 0) * 60;
        } else {
            // الحالة 2: حسب الجلسات
            if (!empty($sessions)) {
                foreach ($sessions as $session) {
                    $start = Carbon::createFromTimeString($session->session_start_time ?? '00:00:00');
                    $end = Carbon::createFromTimeString($session->session_end_time ?? '00:00:00');

                    // إذا وقت النهاية أقل من أو يساوي وقت البداية نضيف يوم
                    if ($end->lessThanOrEqualTo($start)) {
                        $end->addDay();
                    }

                    $totalMinutes += $end->diffInMinutes($start, true);
                }
            }
        }

        $totalHours = round($totalMinutes / 60, 2);

        // تحويل الساعات إلى نص عربي
        $hours = floor($totalHours);
        $minutes = round(($totalHours - $hours) * 60);

        $durationText = '';
        if ($hours > 0) {
            $durationText .= $hours . ' ساعة';
        }
        if ($minutes > 0) {
            if ($hours > 0) $durationText .= ' و ';
            $durationText .= $minutes . ' دقيقة';
        }
        if ($durationText === '') {
            $durationText = '0 دقيقة';
        }

        return [
            'total_hours' => $totalHours,
            'duration_text' => $durationText,
        ];
    }
}
