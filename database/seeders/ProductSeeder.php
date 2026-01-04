<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 38; $i++) {

            if ($i <= 14) {
                $category = 1;
                $price = rand(50, 100) * 1000;
            } elseif ($i <= 28) {
                $category = 2;
                $price = rand(70, 120) * 1000;
            } else {
                $category = 3;
                $price = rand(80, 130) * 1000;
            }

            Product::create([
                'name'        => "Artwork #{$i}",
                'price'       => $price,
                'description' => "Karya seni nomor {$i}.",
                'image' => "products/{$i}.jpg",
                'category_id' => $category,
            ]);
        }
    }
}
