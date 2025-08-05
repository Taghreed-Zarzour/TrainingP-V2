<?php

namespace App\Enums;

enum TrainerStatusEnum: string
{
    case AvailableFullTime = 'متاح طوال الأسبوع';
    case AvailableWeekends = 'متاح فقط في أيام العطل';
    case TemporarilyUnavailable = 'غير متاح مؤقتًا';
}