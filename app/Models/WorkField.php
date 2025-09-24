<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkField extends Model
{
    public $fillable = [
        'name',
    ];
    
    public function trainers()
    {
        return $this->hasMany(Trainer::class, 'work_fields_id');
    }

    public function trainees()
    {
        return $this->hasMany(Trainee::class, 'work_fields_id');
    }
}
