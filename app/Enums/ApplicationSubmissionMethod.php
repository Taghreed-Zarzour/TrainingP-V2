<?php

namespace App\Enums;

enum ApplicationSubmissionMethod: string
{
    case InsidePlatform = 'inside_platform';
    case OutsidePlatform = 'outside_platform';

    public function label(): string
    {
        return match($this) {
            self::InsidePlatform => 'داخل المنصة',
            self::OutsidePlatform => 'خارج المنصة',
        };
    }
}
