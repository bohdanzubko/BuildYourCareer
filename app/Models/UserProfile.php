<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'avatar_url',
        'bio',
        'location',
        'phone',
        'website',
        'company_name',
        'company_description',
        'rating',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // (опціонально) зв’язок із портфоліо, якщо реалізовано окремою таблицею
    // public function portfolio()
    // {
    //     return $this->hasMany(Portfolio::class);
    // }
}
