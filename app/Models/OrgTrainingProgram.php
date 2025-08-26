<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrgTrainingProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'title',
        'language_id',
        'country_id',
        'city',
        'address_in_detail',
        'program_type',
        'training_level_id',
        'program_presentation_method',
        'org_training_classification_id',
        'program_description',
        'is_edit_mode',
        'status',
    ];

    protected $casts = [
        'org_training_classification_id' => 'array',
        'is_edit_mode' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function goals()
    {
        return $this->hasMany(OrgTrainingGoal::class);
    }

    public function details()
    {
        return $this->hasMany(OrgTrainingDetail::class);
    }

    public function assistants()
    {
        return $this->hasMany(OrgAssistantManagement::class);
    }

    public function assistantUsers()
    {
        return $this->belongsToMany(User::class, 'org_assistant_managements', 'org_training_program_id', 'assistant_id');
    }


    public function registrationRequirements()
    {
        return $this->hasOne(OrgRegistrationAndRequirement::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function trainingClassification()
    {
        return $this->belongsTo(TrainingClassification::class, 'org_training_classification_id');
    }

    public function trainingLevel()
    {
        return $this->belongsTo(trainingLevel::class, 'training_level_id');
    }
    
        public function programType()
    {
        return $this->belongsTo(programType::class, 'program_type');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

// App\Models\OrgTrainingProgram.php
public function files()
{
    return $this->hasMany(OrgTrainingDetailFile::class, 'org_training_program_id');
}
public function trainingSchedules()
    {
        return $this->hasMany(OrgTrainingSchedule::class, 'org_training_prgram_id');
    }

}
