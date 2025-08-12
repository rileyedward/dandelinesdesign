<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Romantic Bridal Bouquet',
                'description' => 'Elegant bridal bouquet featuring white roses, peonies, and eucalyptus with silk ribbon wrap. Perfect for classic wedding ceremonies.',
                'price' => '125.00',
                'is_active' => true,
            ],
            [
                'name' => 'Wedding Centerpiece Collection',
                'description' => 'Set of 8 matching centerpieces with seasonal flowers in gold mercury glass vases. Includes candles for romantic ambiance.',
                'price' => '480.00',
                'is_active' => true,
            ],
            [
                'name' => 'Ceremony Arch Decoration',
                'description' => 'Stunning floral arch decoration with cascading flowers and greenery. Perfect backdrop for wedding vows.',
                'price' => '350.00',
                'is_active' => true,
            ],

            [
                'name' => 'Executive Lobby Arrangement',
                'description' => 'Professional large-scale arrangement for corporate lobbies and reception areas. Modern design with premium flowers.',
                'price' => '200.00',
                'is_active' => true,
            ],
            [
                'name' => 'Conference Table Centerpieces',
                'description' => 'Low-profile arrangements perfect for business meetings and conferences. Won\'t obstruct conversation.',
                'price' => '75.00',
                'is_active' => true,
            ],

            [
                'name' => 'Birthday Celebration Bouquet',
                'description' => 'Vibrant and cheerful mixed bouquet with colorful seasonal flowers. Includes "Happy Birthday" ribbon.',
                'price' => '65.00',
                'is_active' => true,
            ],
            [
                'name' => 'Kids Birthday Party Package',
                'description' => 'Fun and colorful arrangements designed especially for children\'s parties. Bright colors and playful designs.',
                'price' => '120.00',
                'is_active' => true,
            ],

            [
                'name' => 'Peaceful Sympathy Arrangement',
                'description' => 'Elegant white and green sympathy arrangement with lilies, roses, and eucalyptus. Includes sympathy card.',
                'price' => '95.00',
                'is_active' => true,
            ],
            [
                'name' => 'Standing Funeral Spray',
                'description' => 'Large standing spray arrangement for funeral services. Available in traditional and contemporary styles.',
                'price' => '175.00',
                'is_active' => true,
            ],

            [
                'name' => 'Christmas Centerpiece',
                'description' => 'Festive holiday centerpiece with red roses, pine, and gold accents. Perfect for Christmas dinner tables.',
                'price' => '85.00',
                'is_active' => true,
            ],
            [
                'name' => 'Valentine\'s Day Romance',
                'description' => 'Classic dozen red roses in elegant vase with baby\'s breath and greenery. Includes chocolates.',
                'price' => '110.00',
                'is_active' => true,
            ],

            [
                'name' => 'Anniversary Rose Garden',
                'description' => 'Luxurious arrangement of premium roses in anniversary colors. Available in various color combinations.',
                'price' => '135.00',
                'is_active' => true,
            ],
            [
                'name' => 'Golden Anniversary Special',
                'description' => 'Elegant arrangement in gold and yellow tones celebrating 50 years of love. Includes special anniversary card.',
                'price' => '155.00',
                'is_active' => false,
            ],

            [
                'name' => 'Designer\'s Choice Bouquet',
                'description' => 'Let our designers create something beautiful with the freshest flowers available. Perfect when you want to surprise.',
                'price' => '75.00',
                'is_active' => true,
            ],
            [
                'name' => 'Weekly Office Flowers',
                'description' => 'Subscription service for fresh office arrangements delivered weekly. Professional and welcoming.',
                'price' => '60.00',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            $category = Category::inRandomOrder()->first();
            $categoryId = $category ? $category->id : Category::factory()->create()->id;

            Product::query()->create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'category_id' => $categoryId,
                'is_active' => $product['is_active'],
            ]);
        }

        Product::factory(20)->create();
    }
}
