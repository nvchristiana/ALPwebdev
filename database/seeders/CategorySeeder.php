<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Digital Art']);
        Category::create(['name' => 'Sketch']);
        Category::create(['name' => 'Painting']);
    }
}
