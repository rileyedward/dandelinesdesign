<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $productNames = [
            'Elegant Rose Bouquet',
            'Modern Art Print - Abstract Waves',
            'Custom Wedding Centerpiece',
            'Seasonal Floral Arrangement',
            'Hand-painted Canvas Original',
            'Corporate Event Decor Package',
            'Botanical Wall Art Collection',
            'Luxury Bridal Bouquet',
        ];

        $name = $this->faker->randomElement($productNames).' #'.$this->faker->numberBetween(1, 999);

        $images = [];
        if ($this->faker->boolean(70)) { // 70% chance of having multiple images
            $imageCount = $this->faker->numberBetween(1, 5);
            for ($i = 0; $i < $imageCount; $i++) {
                $images[] = $this->faker->imageUrl(600, 600, 'nature');
            }
        }

        return [
            'stripe_product_id' => 'prod_' . $this->faker->unique()->randomNumber(8),
            'category_id' => function () {
                $category = Category::inRandomOrder()->first();
                return $category ? $category->id : Category::factory()->create()->id;
            },
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(2, true),
            'image_url' => $this->faker->optional(0.8)->imageUrl(400, 400, 'nature'),
            'images' => !empty($images) ? $images : null,
            'package_dimensions' => $this->faker->optional(0.6)->randomElement([
                '12x8x4',
                '10x10x6',
                '16x12x8',
                '8x8x2',
                '20x16x10'
            ]),
            'weight' => $this->faker->optional(0.7)->randomFloat(2, 0.5, 25.0), // Weight in ounces
            'shippable' => $this->faker->boolean(85), // 85% chance of being shippable
            'tax_code' => $this->faker->optional(0.3)->randomElement([
                'txcd_99999999', // General
                'txcd_10010001', // Books
                'txcd_30070000', // Digital goods
                'txcd_20030000'  // Clothing
            ]),
            'metadata' => $this->faker->optional(0.4)->randomElements([
                'artist' => $this->faker->name(),
                'collection' => $this->faker->randomElement(['Spring 2024', 'Wedding Collection', 'Modern Series']),
                'material' => $this->faker->randomElement(['Canvas', 'Paper', 'Metal', 'Wood']),
                'care_instructions' => $this->faker->sentence()
            ], null, true),
            'unit_label' => $this->faker->optional(0.3)->randomElement([
                'piece',
                'set',
                'arrangement',
                'print',
                'bouquet'
            ]),
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}
