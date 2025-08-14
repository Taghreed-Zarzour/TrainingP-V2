<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrgTrainingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_program_id',
        'org_training_program_id',
        'trainer_id',
        'session_date',
        'session_start_time',
        'session_end_time',
        'schedule_later',
        'training_files',
    ];


    public function trainingProgram()
    {
        return $this->belongsTo(OrgTrainingProgram::class);
    }
}
