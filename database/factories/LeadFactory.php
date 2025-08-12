<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->optional(0.8)->phoneNumber(),
            'company' => $this->faker->optional(0.6)->company(),
            'status' => $this->faker->randomElement(['new', 'contacted', 'qualified', 'proposal', 'won', 'lost']),
            'source' => $this->faker->randomElement(['website', 'referral', 'social_media', 'advertising', 'other']),
            'notes' => $this->faker->optional(0.7)->paragraph(),
        ];
    }
}
