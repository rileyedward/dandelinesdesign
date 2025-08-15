<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 10, 500);
        $taxRate = 0.08; // 8% tax rate
        $taxAmount = $subtotal * $taxRate;
        $shippingCost = $this->faker->randomFloat(2, 5, 25);
        $totalAmount = $subtotal + $taxAmount + $shippingCost;

        return [
            'order_number' => 'ORD-'.strtoupper($this->faker->unique()->bothify('??######')),
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'currency' => 'USD',

            // Customer Information
            'customer_email' => $this->faker->email(),
            'customer_first_name' => $this->faker->firstName(),
            'customer_last_name' => $this->faker->lastName(),
            'customer_phone' => $this->faker->phoneNumber(),

            // Shipping Address (sometimes same as billing)
            'shipping_address_line_1' => $this->faker->streetAddress(),
            'shipping_address_line_2' => $this->faker->boolean(30) ? $this->faker->secondaryAddress() : null,
            'shipping_city' => $this->faker->city(),
            'shipping_state' => $this->faker->stateAbbr(),
            'shipping_postal_code' => $this->faker->postcode(),
            'shipping_country' => 'US',

            // Shipping Information
            'shipping_method' => $this->faker->randomElement(['standard', 'express', 'overnight', 'pickup']),
            'tracking_number' => $this->faker->boolean(60) ? $this->faker->bothify('1Z###??#########') : null,
            'shipped_at' => $this->faker->boolean(50) ? $this->faker->dateTimeBetween('-30 days', 'now') : null,
            'delivered_at' => $this->faker->boolean(30) ? $this->faker->dateTimeBetween('-20 days', 'now') : null,

            // Payment Information
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'payment_method' => $this->faker->randomElement(['stripe', 'paypal', 'apple_pay', 'google_pay']),
            'payment_transaction_id' => $this->faker->uuid(),
            'payment_completed_at' => $this->faker->boolean(70) ? $this->faker->dateTimeBetween('-30 days', 'now') : null,
        ];
    }

    // State methods for different order statuses
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'payment_status' => 'pending',
            'shipped_at' => null,
            'delivered_at' => null,
            'tracking_number' => null,
            'payment_completed_at' => null,
        ]);
    }

    public function processing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'processing',
            'payment_status' => 'paid',
            'shipped_at' => null,
            'delivered_at' => null,
            'payment_completed_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
        ]);
    }

    public function shipped(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'shipped',
            'payment_status' => 'paid',
            'shipped_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
            'delivered_at' => null,
            'tracking_number' => $this->faker->bothify('1Z###??#########'),
            'payment_completed_at' => $this->faker->dateTimeBetween('-14 days', '-7 days'),
        ]);
    }

    public function delivered(): static
    {
        $shippedAt = $this->faker->dateTimeBetween('-14 days', '-3 days');
        $deliveredAt = $this->faker->dateTimeBetween($shippedAt, 'now');

        return $this->state(fn (array $attributes) => [
            'status' => 'delivered',
            'payment_status' => 'paid',
            'shipped_at' => $shippedAt,
            'delivered_at' => $deliveredAt,
            'tracking_number' => $this->faker->bothify('1Z###??#########'),
            'payment_completed_at' => $this->faker->dateTimeBetween('-21 days', $shippedAt),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'payment_status' => $this->faker->randomElement(['pending', 'refunded']),
            'shipped_at' => null,
            'delivered_at' => null,
            'tracking_number' => null,
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => 'paid',
            'payment_completed_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ]);
    }
}
