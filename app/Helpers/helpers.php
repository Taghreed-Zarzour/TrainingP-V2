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
        if (empty($time) || !preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $time)) {
            return 'غير محدد';
        }

        // لو الثواني غير موجودة أضفها تلقائياً
        if (strlen($time) === 5) { // مثلاً "08:30"
            $time .= ':00';
        }

        try {
            $carbonTime = Carbon::createFromFormat('H:i:s', $time);
        } catch (\Exception $e) {
            return 'غير محدد';
        }

        $hour = $carbonTime->format('g'); // 12-hour format بدون صفر بادئ
        $period = $carbonTime->format('A') === 'AM' ? 'صباحًا' : 'مساءً';

        return $hour . ' ' . $period;
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

