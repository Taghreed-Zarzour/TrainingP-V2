<?php

namespace App\Enums;

enum TrainingAttendanceType: string
{
    case ONLINE  = 'اونلاين';
    case  IN_PERSON = 'حضوري';
    case REMOTE  = 'عن بعد';
    case HYBRID = 'هجين';
}
