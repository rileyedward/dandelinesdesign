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

        return [
            'category_id' => function () {
                $category = Category::inRandomOrder()->first();

                return $category ? $category->id : Category::factory()->create()->id;
            },
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(2, true),
            'price' => $this->faker->randomFloat(2, 15.00, 500.00),
            'image_url' => $this->faker->optional(0.8)->imageUrl(400, 400, 'nature'),
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}
