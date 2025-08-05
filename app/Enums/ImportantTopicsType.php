<?php

namespace App\Enums;

enum ImportantTopicsType: string
{
    case مقدمة_البرمجة = 'مقدمة البرمجة';
    case تطوير_الويب = 'تطوير الويب';
    case تحليل_البيانات = 'تحليل البيانات';
    case ذكاء_صناعي = 'ذكاء صناعي';

    /**
     * إرجاع جميع القيم كمصفوفة (مفيد للعرض في الـ select)
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
