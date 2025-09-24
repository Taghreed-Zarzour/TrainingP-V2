<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable=[
        'trainee_id',
        'training_programs_id',
        'status',
        'registered_at',
        'rejection_reason',
        'org_training_programs_id',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];


    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'trainee_id');
    }

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'training_programs_id');
    }

}
