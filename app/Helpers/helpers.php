<?php

//لاظهار معاينة الفيديو في الواجهة
function getGoogleDriveId($url) {
    preg_match('/\/d\/(.*?)\//', $url, $matches);
    return $matches[1] ?? '';
}


use Carbon\Carbon;

if (!function_exists('formatTimeArabic')) {
    function formatTimeArabic($time)
    {
        // تحقق من أن الوقت موجود وله صيغة صحيحة (HH:MM أو HH:MM:SS)
        if (empty($time) || !preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $time)) {
            return 'غير محدد';
        }

        // إذا لم تُذكر الثواني، أضفها
        if (strlen($time) === 5) { // مثل "08:30"
            $time .= ':00';
        }

        try {
            $carbonTime = Carbon::createFromFormat('H:i:s', $time);
        } catch (\Exception $e) {
            return 'غير محدد';
        }

        // صيغة 12 ساعة مع الدقائق
        $hour = $carbonTime->format('g');       // الساعة بدون صفر بادئ
        $minute = (int)$carbonTime->format('i'); // إزالة الصفر البادئ إن كان موجود
        $period = $carbonTime->format('A') === 'AM' ? 'صباحًا' : 'مساءً';

        // إذا كانت الدقائق صفر، لا نعرضها
        $formattedTime = $minute > 0 ? "$hour:$minute $period" : "$hour $period";

        return $formattedTime;
    }
}



if (!function_exists('formatDuration')) {
    /**
     * تحسب فرق الوقت بين وقتين (صيغة H:i:s) وترجع نص عربي بالساعة والدقيقة.
     *
     * @param string $startTime صيغة H:i:s
     * @param string $endTime صيغة H:i:s
     * @return string
     */
    function formatDuration($startTime, $endTime)
    {
        if (empty($startTime) || empty($endTime)) {
            return 'غير محدد';
        }

        try {
            $start = new DateTime($startTime);
            $end = new DateTime($endTime);
        } catch (Exception $e) {
            return 'غير محدد';
        }

        $interval = $start->diff($end);

        $hours = $interval->h;
        $minutes = $interval->i;

        $result = '';
        if ($hours > 0) {
            $result .= $hours . ' ' . ($hours == 1 ? 'ساعة' : 'ساعات');
        }

        if ($minutes > 0) {
            if ($hours > 0) {
                $result .= ' ';
            }
            $result .= $minutes . ' دقيقة';
        }

        return $result ?: '0 دقيقة';
    }
}



if (!function_exists('calculateDurationArabic')) {
    function calculateDurationArabic($startTime, $endTime)
    {
        // التحقق من وجود الأوقات
        if (empty($startTime) || empty($endTime)) {
            return '0 دقيقة';
        }

        try {
            $start = Carbon::parse($startTime);
            $end = Carbon::parse($endTime);
        } catch (\Exception $e) {
            return '0 دقيقة'; // إذا صيغة الوقت غير صحيحة
        }

        // إذا كانت النهاية قبل البداية نعتبر المدة صفر (تجنب القيم السالبة)
        if ($end->lessThanOrEqualTo($start)) {
            return '0 دقيقة';
        }

        // حساب المدة بالدقائق
        $diffInMinutes = $start->diffInMinutes($end);

        // إذا كانت أقل من 60 دقيقة → عرض بالدقائق فقط
        if ($diffInMinutes < 60) {
            return $diffInMinutes . ' دقيقة';
        }

        // إذا كانت ساعة فأكثر → تقسيم لساعات ودقائق
        $hours = floor($diffInMinutes / 60);
        $minutes = $diffInMinutes % 60;

        $result = $hours . ' ساعة';
        if ($minutes > 0) {
            $result .= ' و' . $minutes . ' دقيقة';
        }

        return $result;
    }
}



if (!function_exists('calculateTotalSessionsDuration')) {
    /**
     * حساب المدة الكلية لكل الجلسات
     *
     * @param \Illuminate\Support\Collection|array $sessions
     * @param bool $formatted (true = إرجاع النص "X ساعة وY دقيقة"، false = إرجاع الدقائق فقط)
     * @return string|int
     */
    function calculateTotalSessionsDuration($sessions, $formatted = true)
    {
        if (empty($sessions) || count($sessions) === 0) {
            return $formatted ? '0 دقيقة' : 0;
        }

        $totalMinutes = 0;

        foreach ($sessions as $session) {
            if (empty($session->session_start_time) || empty($session->session_end_time)) {
                continue; // تجاهل الجلسات الناقصة
            }

            try {
                $start = Carbon::parse($session->session_start_time);
                $end = Carbon::parse($session->session_end_time);
            } catch (\Exception $e) {
                continue; // تجاهل الجلسات غير الصالحة
            }

            if ($end->greaterThan($start)) {
                $totalMinutes += $start->diffInMinutes($end);
            }
        }

        if (!$formatted) {
            return $totalMinutes; // إرجاع الدقائق فقط
        }

        // تحويل لساعات ودقائق بشكل نصي
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        if ($hours === 0 && $minutes === 0) {
            return '0 دقيقة';
        }

        if ($hours > 0 && $minutes > 0) {
            return "$hours ساعة و$minutes دقيقة";
        } elseif ($hours > 0) {
            return "$hours ساعة";
        } else {
            return "$minutes دقيقة";
        }
    }
}
