<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class trainingAssistantManagement extends Model
{
    protected $table = 'training_assistant_managements';
    
    protected $fillable = [
        'trainer_id',
        'assistant_id',
        'trainer_ids',
        'assistant_ids',
        'training_program_id'
    ];
    
    protected $casts = [
        'trainer_ids' => 'array',
        'assistant_ids' => 'array',
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
    
    // الحصول على جميع المدربين (سواء من trainer_id أو trainer_ids)
    public function getAllTrainers()
    {
        $trainers = [];
        
        if ($this->trainer_id) {
            $trainers[] = $this->trainer_id;
        }
        
        if ($this->trainer_ids) {
            $trainers = array_merge($trainers, $this->trainer_ids);
        }
        
        return array_unique($trainers);
    }
    
    // الحصول على جميع المساعدين (سواء من assistant_id أو assistant_ids)
    public function getAllAssistants()
    {
        $assistants = [];
        
        if ($this->assistant_id) {
            $assistants[] = $this->assistant_id;
        }
        
        if ($this->assistant_ids) {
            $assistants = array_merge($assistants, $this->assistant_ids);
        }
        
        return array_unique($assistants);
    }
}