<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $imagesPath = public_path('images');
        $images = array_filter(scandir($imagesPath), function ($item) use ($imagesPath) {
            return ! is_dir($imagesPath.'/'.$item) && $item !== '.' && $item !== '..' && $item !== '.DS_Store';
        });

        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'image_url' => '/images/'.($images ? $images[array_rand($images)] : ''),
            'price' => fake()->randomFloat(2, 5, 100),
            'is_available' => fake()->boolean(80),
        ];
    }
}
