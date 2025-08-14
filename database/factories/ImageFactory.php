<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    public function definition(): array
    {
        $filename = $this->faker->uuid().'.jpg';

        return [
            'filename' => $filename,
            'original_filename' => $this->faker->words(3, true).'.jpg',
            'path' => 'images/'.$filename,
            'url' => '/storage/images/'.$filename,
            'mime_type' => 'image/jpeg',
            'size' => $this->faker->numberBetween(50000, 2000000),
            'alt_text' => $this->faker->sentence(),
        ];
    }
}
