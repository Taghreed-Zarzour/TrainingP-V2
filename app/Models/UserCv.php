<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UserCv extends Model
{
    use HasTranslations;

    protected $fillable = [
        'cv_file',
        'user_id',
    ];

    public array $translatable = ['last_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}