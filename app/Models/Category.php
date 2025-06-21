<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',  // Automatically cast created_at to a datetime
            'updated_at' => 'datetime',  // Automatically cast updated_at to a datetime
        ];
    }

    public function jobs() {
        return $this->hasMany(Job::class);
    }
    public function services() {
        return $this->hasMany(Service::class);
    }
}
