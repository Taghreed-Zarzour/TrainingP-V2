<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class trainingAssistantManagement extends Model
{
    protected $table = 'training_assistant_managements';
    protected $fillable = [
        'trainer_id',
        'assistant_id',
        'training_program_id'
    ];
    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function assistant()
    {
        return $this->belongsTo(User::class, 'assistant_id');
    }
}
