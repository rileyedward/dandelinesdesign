<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement(['one_time', 'recurring']);
        $unitAmount = $this->faker->randomFloat(2, 5.00, 500.00);

        $recurring = null;
        if ($type === 'recurring') {
            $recurring = [
                'interval' => $this->faker->randomElement(['day', 'week', 'month', 'year']),
                'interval_count' => $this->faker->numberBetween(1, 12),
                'usage_type' => $this->faker->randomElement(['licensed', 'metered']),
            ];
        }

        return [
            'stripe_price_id' => 'price_'.$this->faker->unique()->randomNumber(8),
            'active' => $this->faker->boolean(90), // 90% chance of being active
            'currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP']),
            'type' => $type,
            'unit_amount' => $unitAmount,
            'unit_amount_decimal' => (int) ($unitAmount * 100), // Convert to cents
            'billing_scheme' => $type === 'recurring' ? $this->faker->randomElement(['per_unit', 'tiered']) : null,
            'recurring' => $recurring,
            'usage_type' => $type === 'recurring' ? $this->faker->randomElement(['licensed', 'metered']) : null,
            'tax_behavior' => $this->faker->boolean(70), // 70% chance of being inclusive
            'nickname' => $this->faker->optional(0.3)->words(2, true), // 30% chance of having a nickname
            'metadata' => $this->faker->optional(0.2)->randomElements([
                'priority' => $this->faker->randomElement(['high', 'medium', 'low']),
                'category' => $this->faker->randomElement(['standard', 'premium', 'discount']),
                'seasonal' => $this->faker->boolean(),
            ], null, true),
            'stripe_created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
