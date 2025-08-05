<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingExperience extends Model
{
    protected $fillable = [
        'trainer_id',
        'title_id',
        'country_id',
        'authority',
        'engagement_type',
        'trainees_number',
        'trainees_type',
        'hours_number',
        'description',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function title()
    {
        return $this->belongsTo(ProvidedService::class, 'title_id');
    }


}