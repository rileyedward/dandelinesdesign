<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Available Products
        Product::factory()
            ->count(8)
            ->state([
                'is_available' => true,
            ])
            ->create();

        // Unavailable Products
        Product::factory()
            ->count(3)
            ->state([
                'is_available' => false,
            ])
            ->create();
    }
}
