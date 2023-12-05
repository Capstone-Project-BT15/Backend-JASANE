<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['title' => 'Pertukangan', 'slug' =>'pertukangan'],
            ['title' => 'Cuci Baju', 'slug' =>'cuci-baju'],
            ['title' => 'Cuci Piring', 'slug' =>'cuci-piring'],
            ['title' => 'Setrika', 'slug' =>'setrika'],
            ['title' => 'Menyapu', 'slug' =>'menyapu'],
            ['title' => 'Mengepel', 'slug' =>'mengepel'],
            ['title' => 'Service Elektronik', 'slug' =>'service-elektronik'],
            ['title' => 'Tani Harian', 'slug' =>'tani-harian'],
            ['title' => 'Memasak', 'slug' =>'memasak'],
            ['title' => 'Baby Sitter', 'slug' =>'baby-sitter']
        ]);
    }
}
