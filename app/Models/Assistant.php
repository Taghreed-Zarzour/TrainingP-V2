<?php

namespace App\Models;

use App\Enums\SexEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Assistant extends Model
{
    use HasTranslations;

    public array $translatable = ['last_name'];

    protected $fillable = [
        'id',
        'last_name',
        'sex',
        'headline',
        'nationality',
        'years_of_experience',
        'experience_areas',
        'provided_services',
        'specialization',
        'university',
        'graduation_year',
        'education_levels_id',
        'languages',
    ];

    protected $casts = [
        'sex' => SexEnum::class,
        'experience_areas' => 'array',
        'provided_services' => 'array',
        'nationality' => 'array',
        'languages' => 'array',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }


    public function experienceArea()
    {
        return $this->belongsTo(ExperienceArea::class, 'experience_areas_id');
    }

    public function providedService()
    {
        return $this->belongsTo(ProvidedService::class, 'provided_services_id');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_levels_id');
    }
}
