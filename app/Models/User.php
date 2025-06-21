<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_user');
    }

    public function confirmedJobs()
    {
        return $this->hasMany(JobConfirmation::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
    public function jobs()
    {
        return $this->hasMany(Job::class, 'employer_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'user_services');
    }
}
