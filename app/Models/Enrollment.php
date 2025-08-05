<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable=[
        'trainee_id',
        'training_programs_id',
        'status',
        'registered_at',
        'rejection_reason',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];


}
