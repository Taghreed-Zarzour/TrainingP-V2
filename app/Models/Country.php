<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function trainers()
    {
        return $this->hasMany(Trainer::class, 'nationality_id');
    }

    public function assistants()
    {
        return $this->hasMany(Assistant::class, 'nationality_id');
    }
      public function trainees()
    {
        return $this->hasMany(Trainee::class, 'nationality_id');
    }

    public function jobAds()
    {
        return $this->hasMany(JobAd::class);
    }
}
