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
    ];

    protected $casts = [
        'org_training_classification_id' => 'array',
    ];
    
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
        return $this->belongsTo(TrainingLevel::class, 'training_level_id');
    }

}
