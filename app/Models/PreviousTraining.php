<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreviousTraining extends Model
{
    protected $table = 'previous_training';

    protected $fillable = [
        'video_link',
        'training_title',
        'description',
        'trainer_id',
    ];
}
