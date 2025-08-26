<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrgTrainingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_title',
        'org_training_program_id',
        'trainer_id',
        'schedule_later',
        'num_of_session',
        'num_of_hours',

    ];

    public function trainingProgram()
    {
        return $this->belongsTo(OrgTrainingProgram::class, 'org_training_program_id');
    }

    public function trainingSchedules()
    {
        return $this->hasMany(OrgTrainingSchedule::class, 'org_training_detail_id');
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }


}