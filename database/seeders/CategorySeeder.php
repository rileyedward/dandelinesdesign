<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Wedding Flowers',
                'description' => 'Floral arrangements for weddings and ceremonies.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Special',
                'description' => 'Arrangements for birthdays, anniversaries, and celebrations.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Seasonal',
                'description' => 'Seasonal flower arrangements and holiday designs.',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($categories as $category) {
            Category::query()->create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
                'sort_order' => $category['sort_order'],
            ]);
        }
    }
}
