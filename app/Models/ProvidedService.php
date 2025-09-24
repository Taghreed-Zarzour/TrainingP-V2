<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvidedService extends Model
{
    public function trainers()
    {
        return $this->hasMany(Trainer::class, 'provided_services_id');
    }

    public function assistants()
    {
        return $this->hasMany(Assistant::class, 'provided_services_id');
    }


}
