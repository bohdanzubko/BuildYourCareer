<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        Feedback::create([
            'user_id' => 2, // Worker
            'job_id' => 1,
            'rating' => 5,
            'comment' => 'Добре організований проєкт, чіткі інструкції та своєчасна оплата.',
        ]);

        Feedback::create([
            'user_id' => 2,
            'job_id' => 2,
            'rating' => 4,
            'comment' => 'Проєкт виявився складнішим за очікування, але в цілому все добре.',
        ]);
    }
}
