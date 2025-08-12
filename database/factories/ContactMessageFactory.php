<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'business_name' => $this->faker->optional(0.7)->company(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->optional(0.8)->phoneNumber(),
            'subject' => $this->faker->optional(0.9)->sentence(),
            'message' => $this->faker->paragraph(3),
            'is_read' => $this->faker->boolean(20),
        ];
    }
}
