<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $fillable = [
        'users_id',
        'title',
        'the_authority',
        'start_date',
        'end_date',
        'country_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    
}
