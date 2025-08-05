<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalPoint extends Model
{
    public function jobAd()
    {
        return $this->belongsTo(JobAd::class, 'job_ads_id');
    }
}