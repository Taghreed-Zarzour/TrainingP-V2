<?php

namespace App\Services;

use App\Models\Assistant;
use App\Models\Organization;
use App\Models\Trainee;
use App\Models\Trainer;

class HomeService
{
    public function checkUserProfile($user)
    {
        switch ($user->user_type_id) {
            case 1: // Trainer
                return Trainer::where('id', $user->id)->exists();
            case 2: // Assistant
                return Assistant::where('id', $user->id)->exists();
            case 3: // Trainee
                return Trainee::where('id', $user->id)->exists();
            case 4: // Organization
                return Organization::where('id', $user->id)->exists();
            default:
                return false; // Unknown user type
        }
    }
}
