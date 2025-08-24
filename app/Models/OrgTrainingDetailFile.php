<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgTrainingDetailFile extends Model
{
    use HasFactory;

    protected $table = 'org_training_detail_files';

    protected $fillable = [
        'org_training_program_id',
        'training_files',
    ];

    

    public function trainingProgram()
    {
        return $this->belongsTo(OrgTrainingProgram::class, 'org_training_program_id');
    }
}