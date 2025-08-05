<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionAttendance extends Model
{
    protected $table = 'session_attendance';

    protected $fillable = [
        'session_id',
        'trainee_id',
        'attended',
    ];

    public function session()
    {
        return $this->belongsTo(schedulingTrainingSessions::class, 'session_id');
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'trainee_id');
    }


}
