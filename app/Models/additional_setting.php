<?php
namespace App\Models;
use App\Enums\ApplicationSubmissionMethod;
use Illuminate\Database\Eloquent\Model;
class additional_setting extends Model
{
    protected $fillable = [
        'training_program_id',
        'is_free',
        'cost',
        'currency',
        'payment_method',
        'country_id',
        'city',
        'residential_address',
        'application_deadline',
        'max_trainees',
        'application_submission_method',
        'registration_link',
        'profile_image',
        'training_files',
        'welcome_message', // إضافة الحقل الجديد

    ];
    protected $casts = [
        'training_files' => 'array',
        'application_deadline' => 'date',
        'cost' => 'decimal:15',
        'application_submission_method'=> ApplicationSubmissionMethod::class,
    ];

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}