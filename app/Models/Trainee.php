<?php

namespace App\Models;

use App\Enums\SexEnum;
use App\Enums\TrainingAttendanceType;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Trainee extends Model
{
    use HasTranslations;



    public array $translatable = ['last_name'];

    protected $fillable = [
        'id',
        'last_name',
        'sex',
        'nationality',
        'work_fields',
        'education_levels_id',
        'fields_of_interest',
        'is_working',
        'job_position',
        'work_sectors',
        'preferred_times',
        'training_attendance',
        'extra_work_field',
        'work_institution'
    ];

    protected $casts = [
        'sex' => SexEnum::class,
        'work_fields' => 'array',
        'nationality' => 'array',
        'fields_of_interest' => 'array',
        'work_sectors' => 'array',
        'preferred_times' => 'array',
        'training_attendance' => TrainingAttendanceType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }



    public function workField()
    {
        return $this->belongsTo(WorkField::class, 'work_fields_id');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_levels_id');
    }


    public function trainingPrograms()
    {
        return $this->belongsToMany(TrainingProgram::class, 'enrollments', 'trainee_id', 'training_programs_id')
                    ->withPivot('status', 'registered_at', 'rejection_reason');
    }

}

