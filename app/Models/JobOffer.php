<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'job_id',
        'offer_price',
        'status',
    ];

    /**
     * Get the job associated with the job offer.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the user associated with the job offer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
