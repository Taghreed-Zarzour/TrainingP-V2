<?php

namespace App\Enums;

enum InvestmentValuesEnum : string
{
    case RANGE_100_500     = 'بين 100 و 500 دولار';
    case RANGE_501_1000    = 'بين 501 و 1000 دولار';
    case RANGE_1001_3000   = 'بين 1001 و 3000 دولار';
    case RANGE_3001_5000   = 'بين 3001 و 5000 دولار';
    case RANGE_5001_PLUS   = 'أكثر من 5000 دولار';

    public function label(): string
    {
        return $this->value;
    }

}
