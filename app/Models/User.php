<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable , HasApiTokens, HasTranslations;

    public array $translatable = ['name'];
    protected $rememberTokenName = 'remember_token';
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id',
        'bio',
        'country_id',
        'city',
        'phone_code',
        'phone_number',
        'photo',
    ];

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    public function feedbacks()
{
    return $this->hasMany(feedback::class);
}


public function nationalities()
{
    return $this->belongsToMany(Country::class, 'user_nationalities', 'user_id', 'country_id');
}


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function trainer()
    {
        return $this->hasOne(Trainer::class, 'id');
    }

    public function assistant()
    {
        return $this->hasOne(Assistant::class, 'id');
    }

    public function trainee()
    {
        return $this->hasOne(Trainee::class, 'id');
    }

    public function organization()
    {
        return $this->hasMany(Organization::class);
    }


    public function userCv()
    {
        return $this->hasOne(UserCv::class, 'user_id');
    }


    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function trainingPrograms()
{
    return $this->hasMany(TrainingProgram::class, 'user_id');
}

}
