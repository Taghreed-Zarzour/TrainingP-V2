<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgRegistrationAndRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_training_program_id',
        'cost',
        'is_free',
        'currency',
        'payment_method',
        'application_deadline',
        'max_trainees',
        'application_submission_method',
        'registration_link',
        'requirements',
        'benefits',
        'training_image',
        'welcome_message',
    ];

    protected $casts = [
        'requirements' => 'array',
        'benefits' => 'array',
    ];

    public function trainingProgram()
    {
        return $this->belongsTo(OrgTrainingProgram::class);
    }
}
