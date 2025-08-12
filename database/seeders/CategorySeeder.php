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
                'description' => 'Beautiful floral arrangements for wedding ceremonies and receptions, including bridal bouquets, boutonnieres, centerpieces, and ceremony decorations.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Corporate Events',
                'description' => 'Professional floral designs for business events, conferences, grand openings, and corporate celebrations.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Birthday Celebrations',
                'description' => 'Festive and colorful arrangements perfect for birthday parties, milestone celebrations, and special occasions.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Sympathy & Funeral',
                'description' => 'Respectful and elegant arrangements to honor loved ones, including casket sprays, standing arrangements, and sympathy bouquets.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Holiday Arrangements',
                'description' => 'Seasonal and holiday-themed floral designs for Christmas, Easter, Thanksgiving, Valentine\'s Day, and other special holidays.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Anniversary Flowers',
                'description' => 'Romantic arrangements celebrating love and commitment for wedding anniversaries and relationship milestones.',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Baby Showers',
                'description' => 'Soft and delicate arrangements perfect for celebrating new arrivals and baby shower celebrations.',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Graduation Flowers',
                'description' => 'Congratulatory arrangements and bouquets to celebrate academic achievements and graduation ceremonies.',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Get Well Flowers',
                'description' => 'Cheerful and uplifting arrangements to brighten someone\'s day during recovery and healing.',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Just Because',
                'description' => 'Beautiful arrangements for no special reason other than to show you care and brighten someone\'s day.',
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Seasonal Collections',
                'description' => 'Special arrangements featuring the best flowers of each season - spring blooms, summer varieties, autumn colors, and winter elegance.',
                'is_active' => false,
                'sort_order' => 11,
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
