<?php
namespace App\Models;
use App\Notifications\OrgViewsNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
class TrainingProgram extends Model
{
    protected $fillable = [
        'title',
        'description',
        'program_type_id',
        'language_type_id',
        'training_classification_id',
        'training_level_id',
        'program_presentation_method_id',
        'user_id',
        'status',
        'schedules_later',
            'num_of_session', 
    'num_of_hours', 
    ];

    protected $casts = [
        'schedules_later' => 'boolean', // تحويل القيمة إلى boolean
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail()
    {
        return $this->hasOne(TrainingDetail::class);
    }

public function assistants()
{
    return $this->hasOne(trainingAssistantManagement::class);
}

// دالة مساعدة للحصول على جميع المدربين
public function getAllTrainers()
{
    $trainers = [];
    
    if ($this->assistants) {
        $trainers = $this->assistants->getAllTrainers();
    }
    
    return $trainers;
}

// دالة مساعدة للحصول على جميع المساعدين
public function getAllAssistants()
{
    $assistants = [];
    
    if ($this->assistants) {
        $assistants = $this->assistants->getAllAssistants();
    }
    
    return $assistants;
}

    public function sessions()
    {
        return $this->hasMany(schedulingTrainingSessions::class, 'training_program_id');
    }

    public function AdditionalSetting()
    {
        return $this->hasOne(additional_setting::class);
    }

    public function programType()
    {
        return $this->belongsTo(programType::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_type_id');
    }

    public function trainingClassification()
    {
        return $this->belongsTo(TrainingClassification::class);
    }

    public function trainingLevel()
    {
        return $this->belongsTo(trainingLevel::class);
    }

    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'enrollments', 'training_programs_id', 'trainee_id')
                    ->withPivot('status', 'registered_at', 'rejection_reason');
    }

    
}