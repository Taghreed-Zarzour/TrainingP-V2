<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingDetail extends Model
{
    protected $fillable = [
        'benefits',
        'target_audience',
        'requirements',
        'learning_outcomes',
        'training_program_id'
    ];

    protected $casts = [
        'learning_outcomes' => 'array',
        'target_audience' => 'array',
        'requirements' => 'array',
        'benefits' => 'array',
    ];

    public function trainingProgram()
{
    return $this->belongsTo(TrainingProgram::class);
}

}
