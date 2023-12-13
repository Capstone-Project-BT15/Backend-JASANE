<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'telephone' => '0853463742',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'telephone' => '0853463778',
            'email' => 'recruiter@gmail.com',
            'password' => bcrypt('recruiter123'),
            'role' => 'recruiter',
        ]);

        User::create([
            'telephone' => '0853463742',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user123'),
            'role' => 'user',
        ]);
    }
}
