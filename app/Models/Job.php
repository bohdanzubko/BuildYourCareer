<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'salary_min',
        'salary_max',
        'location',
        'category_id',
        'employer_id',
    ];

    /**
     * Get the category that owns the job.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill', 'job_id', 'skill_id');
    }

    /**
     * Get the employer that owns the job.
     */
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
