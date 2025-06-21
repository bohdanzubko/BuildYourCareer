<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('AdminPass123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Worker',
            'email' => 'worker@gmail.com',
            'password' => Hash::make('WorkerPass123'),
            'role' => 'worker',
        ]);

        User::create([
            'name' => 'Employer',
            'email' => 'employer@gmail.com',
            'password' => Hash::make('EmployerPass123'),
            'role' => 'employer',
        ]);
    }
}
