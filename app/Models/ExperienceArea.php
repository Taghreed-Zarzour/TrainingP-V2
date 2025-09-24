<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceArea extends Model
{
    public function assistants()
    {
        return $this->hasMany(Assistant::class, 'experience_areas_id');
    }
}
