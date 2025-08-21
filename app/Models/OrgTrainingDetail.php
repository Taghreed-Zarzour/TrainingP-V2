<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrgTrainingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_title',
        'org_training_program_id',
        'trainer_id',
        'training_files',
    ];

    
    
    public function trainingProgram()
    {
        return $this->belongsTo(OrgTrainingProgram::class);
    }
    public function trainingSchedules()
    {
        return $this->hasMany(OrgTrainingSchedule::class, 'org_training_detail_id');
    }
}
