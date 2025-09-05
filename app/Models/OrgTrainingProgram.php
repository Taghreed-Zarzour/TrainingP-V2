<?php

namespace App\Models;

use App\Notifications\OrgViewsNotification;
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
    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'enrollments', 'org_training_programs_id', 'trainee_id')
                    ->withPivot('status', 'registered_at', 'rejection_reason');
    }

// local scopes
public function scopeFreeOrPaid($query, $type)
{
    if (!$type || $type === 'all') {
        return $query;
    }

    return $query->whereHas('registrationRequirements', function ($q) use ($type) {
        if ($type === 'free') {
            $q->where('is_free', 1);
        } elseif ($type === 'paid') {
            $q->where('is_free', 0);
        }
    });
}


public function scopeProviderType($query, $type)
{
    if (!$type || $type === 'all' || $type === 'company') {
        return $query;
    }

    if ($type === 'trainer') {
        // Return nothing
        return $query->whereRaw('0 = 1'); // Always false condition
    }

    return $query;
}


public function scopeSearchTitle($query, $keyword)
{
if (!$keyword) {
    return $query;
}

return $query->where('title', 'like', "%{$keyword}%");
}

public function scopeProgramType($query, $programTypeId)
{
    if (!$programTypeId) {
        return $query;
    }

    return $query->whereJsonContains('org_training_classification_id', (string)$programTypeId);
}

}
