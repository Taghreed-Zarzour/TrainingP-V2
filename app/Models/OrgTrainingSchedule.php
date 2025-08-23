<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgTrainingSchedule extends Model
{
    use HasFactory;
    
    protected $table = 'org_training_schedules';
    protected $fillable = [
        'org_training_detail_id',
        'session_date',
        'session_start_time',
        'session_end_time',
    ];

    public function trainingDetail()
    {
        return $this->belongsTo(OrgTrainingDetail::class, 'org_training_detail_id');
    }
}