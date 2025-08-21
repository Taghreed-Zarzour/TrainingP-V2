<?php

namespace App\Models;

use App\Enums\SexEnum;
use App\Enums\TrainerStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Log;

class Trainer extends Model
{
    use HasTranslations;

    public array $translatable = ['last_name'];

protected $primaryKey = 'id';
public $incrementing = false;

    protected $fillable = [
        'id',
        'last_name',
        'sex',
        'headline',
        'work_sectors',
        'provided_services',
        'work_fields',
        'important_topics',
        'nationality',
        'hourly_wage',
        'international_exp',
        'linkedin_url',
        'website',
        'currency',
    ];


    protected $casts = [
        'sex' => SexEnum::class,
        'work_sectors' => 'array',
        'provided_services' => 'array',
        'work_fields' => 'array',
        'nationality' => 'array',
        'important_topics' => 'array',
        'international_exp' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function trainingPrograms()
    {
        return $this->hasMany(TrainingProgram::class, 'user_id');
    }

    public function previousTraining()
    {
        return $this->hasOne(previousTraining::class, 'trainer_id');
    }


    public function ratings()
    {
    return $this->hasMany(TrainerRating::class);
    }





}
