<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class, 'ads_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function requiredQualifications()
    {
        return $this->hasMany(RequiredQualification::class);
    }

    public function trainingTitles()
    {
        return $this->hasMany(TrainingTitle::class);
    }

    public function requiredDeliveries()
    {
        return $this->hasMany(RequiredDelivery::class);
    }

    public function requiredDocuments()
    {
        return $this->hasMany(RequiredDocument::class);
    }
}