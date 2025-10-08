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

    protected $casts = [
        'training_files' => 'array',
    ];

    public function trainingProgram()
    {
        return $this->belongsTo(OrgTrainingProgram::class, 'org_training_program_id');
    }

    // Accessor to get the file path for easy access
    public function getFilePathAttribute()
    {
        $fileData = $this->training_files;
        return $fileData['stored_path'] ?? null;
    }

    // Accessor to get the original filename
    public function getOriginalNameAttribute()
    {
        $fileData = $this->training_files;
        return $fileData['original_name'] ?? null;
    }
}