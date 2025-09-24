<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{

    public function trainees()
    {
        return $this->hasMany(Trainee::class, 'education_levels_id');
    }
}
