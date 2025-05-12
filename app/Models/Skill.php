<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    // Вказуємо таблицю, якщо її ім'я не відповідає стандарту (skills)
    protected $table = 'skills';

    // Поля, які можна масово заповнювати
    protected $fillable = [
        'name', // Назва скіла
        'category_id', // Категорія скіла (якщо є)
    ];

    // Встановлюємо зв'язок з категорією скілів
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Встановлюємо зв'язок з користувачами, які мають цей скіл
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skill', 'skill_id', 'user_id');
    }

    // Встановлюємо зв'язок з вакансіями, де цей скіл необхідний
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_skill', 'skill_id', 'job_id');
    }

    // Встановлюємо зв'язок з сервісами, де цей скіл запропоновано
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_skill', 'skill_id', 'service_id');
    }
}
