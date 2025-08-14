<?php

namespace App\Enums;

enum programType
{
    case CAMP = 'مخيم'; 
    case WORKSHOP = 'ورشة عمل'; 
    case SEMINAR = 'ندوة'; 
    case CONFERENCE = 'مؤتمر'; 
    case WEBINAR = 'ندوة عبر الإنترنت'; 
    case CERTIFICATION = 'شهادة'; 
    case TRAINING_COURSE = 'دورة تدريبية'; 
}
