<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingDetail extends Model
{
    protected $fillable = [
        'benefits',
        'requirements',
        'learning_outcomes',
        'training_program_id',
        'education_level_id',
        'work_status',
        'work_sector_id',
        'job_position',
        'country_id',
    ];

    protected $casts = [
        'learning_outcomes' => 'array',
        'requirements' => 'array',
        'benefits' => 'array',
        'education_level_id'   => 'array',
        'work_sector_id'       => 'array',
        'work_status'       => 'array',
        'job_position'         => 'array',
        'country_id'           => 'array',
    ];

    public function trainingProgram()
{
    return $this->belongsTo(TrainingProgram::class);
}

}
