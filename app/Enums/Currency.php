<?php

namespace App\Enums;

enum Currency: string
{
    case USD = 'USD';
    case EUR = 'EUR';
    case GBP = 'GBP';
    case JPY = 'JPY';
    case KRW = 'KRW';
    case CNY = 'CNY';
    case SAR = 'SAR';
    case SYP = 'SYP'; // الليرة السورية
    case TRY = 'TRY'; // الليرة التركية

    // اختياري: دالة لإرجاع اسم العملة بالعربي
    public function label(): string
    {
        return match($this) {
            self::USD => 'دولار أمريكي',
            self::EUR => 'يورو',
            self::GBP => 'جنيه إسترليني',
            self::JPY => 'ين ياباني',
            self::KRW => 'وون كوري',
            self::CNY => 'يوان صيني',
            self::SAR => 'ريال سعودي',
            self::SYP => 'ليرة سورية',
            self::TRY => 'ليرة تركية',
        };
    }
    public function symbol(): string
{
    return match($this) {
        self::USD => '$',
        self::EUR => '€',
        self::GBP => '£',
        self::JPY => '¥',
        self::KRW => '₩',
        self::CNY => '¥',
        self::SAR => 'ر.س',
        self::SYP => 'ل.س',
        self::TRY => '₺',
    };
}

}
