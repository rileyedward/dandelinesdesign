<?php

namespace Database\Factories;

use App\Models\QuoteMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteMessageFactory extends Factory
{
    protected $model = QuoteMessage::class;

    public function definition(): array
    {
        $eventTypes = ['Wedding', 'Birthday', 'Corporate Event', 'Anniversary', 'Graduation', 'Holiday Party'];
        $budgetRanges = ['$1,000-$2,500', '$2,500-$5,000', '$5,000-$10,000', '$10,000+'];

        return [
            'name' => fake()->name(),
            'business_name' => fake()->optional(0.7)->company(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional(0.8)->phoneNumber(),
            'event_date' => fake()->dateTimeBetween('+1 month', '+1 year')->format('Y-m-d'),
            'event_type' => fake()->randomElement($eventTypes),
            'event_description' => fake()->paragraph(3),
            'guest_count' => fake()->numberBetween(10, 500),
            'venue_name' => fake()->optional(0.8)->company().' '.fake()->randomElement(['Venue', 'Hall', 'Gardens', 'Ballroom']),
            'venue_address' => fake()->address(),
            'budget_range' => fake()->randomElement($budgetRanges),
            'special_requests' => fake()->optional(0.6)->paragraph(),
        ];
    }
}
