<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    // Поля, які можна масово заповнювати
    protected $fillable = [
        'user_id', 
        'job_id', 
        'rating', 
        'comment'
    ];

    // Встановлюємо зв'язок з користувачем (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Встановлюємо зв'язок з роботою (job)
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
