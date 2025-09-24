<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgSessionAttendance extends Model
{
    protected $fillable =[
        'session_id',
        'trainee_id',
        'attended'
    ];

    public function session()
    {
        return $this->belongsTo(OrgTrainingSchedule::class, 'session_id');
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'trainee_id');
    }
}
