<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        Job::create([
            'user_id' => 3, // Employer
            'title' => 'Потрібен плиточник',
            'description' => 'Необхідно укласти плитку у ванній кімнаті, приблизно 20 м².',
            'location' => 'Львів',
            'salary' => 12000,
        ]);

        Job::create([
            'user_id' => 3,
            'title' => 'Монтаж гіпсокартону',
            'description' => 'Робота з гіпсокартонними конструкціями в офісі, близько 35 м².',
            'location' => 'Івано-Франківськ',
            'salary' => 16000,
        ]);
    }
}
