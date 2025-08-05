<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }

    public function jobAds()
    {
        return $this->hasMany(JobAd::class);
    }
}
