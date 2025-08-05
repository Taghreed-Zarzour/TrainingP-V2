<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSector extends Model
{
    public function trainers()
    {
        return $this->hasMany(Trainer::class, 'work_sectors_id');
    }
}
