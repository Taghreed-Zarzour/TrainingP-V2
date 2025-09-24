<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class schedulingTrainingSessions extends Model
{
    protected $fillable = [

        'training_program_id',
        'session_date',
        'session_start_time',
        'session_end_time'
    ];
    public function trainingProgram()
{
    return $this->belongsTo(TrainingProgram::class);
}

public function attendances()
{
    return $this->hasMany(SessionAttendance::class, 'session_id');
}




}
