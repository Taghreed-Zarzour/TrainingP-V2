<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgAssistantManagement extends Model
{
    use HasFactory;

    protected $table = 'org_assistant_managements';
    protected $fillable = [
        'org_training_program_id',
        'assistant_id',
    ];

    public function trainingProgram()
    {
        return $this->belongsTo(OrgTrainingProgram::class);
    }
}
