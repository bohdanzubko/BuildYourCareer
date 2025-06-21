<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            ['name' => 'Штукатурні роботи', 'description' => 'Оздоблення стін штукатуркою', 'price' => 250],
            ['name' => 'Укладка плитки', 'description' => 'Робота з плитковими матеріалами', 'price' => 350],
            ['name' => 'Монтаж гіпсокартону', 'description' => 'Установка перегородок', 'price' => 300],
        ]);
    }
}
