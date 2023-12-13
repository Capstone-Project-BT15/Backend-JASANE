<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rating::create([
            'user_id' => 3,
            'work_id' => 1,
            'comment' => 'Kinerjanya sangat bagus',
            'star' => 5,
        ]);

        Rating::create([
            'user_id' => 3,
            'work_id' => 1,
            'comment' => 'Kinerjanya sangat bagus',
            'star' => 2,
        ]);

        Rating::create([
            'user_id' => 3,
            'work_id' => 1,
            'comment' => 'Kinerjanya sangat bagus',
            'star' => 5,
        ]);
    }
}
