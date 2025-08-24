<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrgTrainingGoal extends Model
{
    use HasFactory;

  protected $fillable = [
    'org_training_program_id',
    'learning_outcomes',
    'education_level_id',
    'work_status',
    'work_sector_id',
    'job_position',
    'country_id',
];

protected $casts = [
    'learning_outcomes'    => 'array',
    'education_level_id'   => 'array',
    'work_sector_id'       => 'array',
      'work_status'       => 'array',
    'job_position'         => 'array',
    'country_id'           => 'array',
];


    public function trainingProgram()
    {
        return $this->belongsTo(OrgTrainingProgram::class);
    }
    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class);
    }
    public function workSector()
    {
        return $this->belongsTo(WorkSector::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
