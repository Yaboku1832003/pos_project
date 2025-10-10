<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Classic White T-Shirt',
                'cost_price' => 8000,
                'sale_price' => 12000,
                'description' => 'A soft, breathable cotton T-shirt perfect for everyday wear.',
                'category_id' => 2,
                'stock' => 50,
                'image' => 'tshirt_white.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Denim Jeans',
                'cost_price' => 20000,
                'sale_price' => 30000,
                'description' => 'Durable blue denim jeans with a slim fit.',
                'category_id' => 2,
                'stock' => 30,
                'image' => 'jeans_denim.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hooded Sweatshirt',
                'cost_price' => 18000,
                'sale_price' => 25000,
                'description' => 'A cozy hoodie made from premium cotton blend for comfort and warmth.',
                'category_id' => 2,
                'stock' => 40,
                'image' => 'hoodie_black.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => 'HalfZipped Sweatshirt',
                'cost_price' => 18000,
                'sale_price' => 25000,
                'description' => 'A cozy hoodie made from premium cotton blend for comfort and warmth.',
                'category_id' => 2,
                'stock' => 40,
                'image' => 'hoodie_black.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => 'Boxer',
                'cost_price' => 18000,
                'sale_price' => 25000,
                'description' => 'A cozy hoodie made from premium cotton blend for comfort and warmth.',
                'category_id' => 2,
                'stock' => 40,
                'image' => 'hoodie_black.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => 'Shirt',
                'cost_price' => 18000,
                'sale_price' => 25000,
                'description' => 'A cozy hoodie made from premium cotton blend for comfort and warmth.',
                'category_id' => 2,
                'stock' => 40,
                'image' => 'hoodie_black.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
