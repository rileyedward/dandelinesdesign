<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteRequestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone_number' => $this->faker->optional(0.8)->phoneNumber(),
            'service_type' => $this->faker->randomElement(['floral_design', 'event_planning', 'both']),
            'event_date' => $this->faker->optional(0.9)->dateTimeBetween('+1 month', '+1 year'),
            'event_location' => $this->faker->optional(0.8)->address(),
            'guest_count' => $this->faker->optional(0.7)->numberBetween(10, 500),
            'budget' => $this->faker->optional(0.6)->randomFloat(2, 500, 25000),
            'description' => $this->faker->paragraph(3),
            'status' => $this->faker->randomElement(['pending', 'contacted', 'quoted', 'completed', 'cancelled']),
        ];
    }
}
