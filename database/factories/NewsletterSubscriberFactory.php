<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterSubscriberFactory extends Factory
{
    public function definition(): array
    {
        $subscribedAt = $this->faker->dateTimeBetween('-2 years', 'now');
        $status = $this->faker->randomElement(['active', 'inactive', 'unsubscribed']);

        return [
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->optional(0.8)->name(),
            'status' => $status,
            'subscribed_at' => $subscribedAt,
            'unsubscribed_at' => $status === 'unsubscribed' ? $this->faker->dateTimeBetween($subscribedAt, 'now') : null,
            'source' => $this->faker->optional(0.6)->randomElement(['website', 'popup', 'footer', 'contact_form', 'event', 'referral']),
            'preferences' => $this->faker->optional(0.3)->randomElements(['weekly_digest', 'product_updates', 'promotions', 'events'], $this->faker->numberBetween(1, 3)),
            'tags' => $this->faker->optional(0.4)->randomElements(['vip', 'local', 'frequent_buyer', 'event_planner', 'wholesale'], $this->faker->numberBetween(1, 2)),
        ];
    }
}
