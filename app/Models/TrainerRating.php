<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerRating extends Model
{
    protected $fillable = [
        'trainer_id',
        'trainee_id',
        'clarity',
        'interaction',
        'organization',
        'comment',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'trainee_id');
    }

}
