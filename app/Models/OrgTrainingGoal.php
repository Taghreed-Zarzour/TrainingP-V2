<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrgTrainingGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_training_program_id',
        'learning_outcomes',
        'target_audience',
    ];

    protected $casts = [
        'learning_outcomes' => 'array',
        'target_audience' => 'array',
    ];

    public function trainingProgram()
    {
        return $this->belongsTo(OrgTrainingProgram::class);
    }
}
