<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    protected $model = OrderProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'unit_price' => $this->faker->randomFloat(2, 5, 200),
        ];
    }

    // State methods for specific scenarios
    public function forOrder(Order $order): static
    {
        return $this->state(fn (array $attributes) => [
            'order_id' => $order->id,
        ]);
    }

    public function forProduct(Product $product): static
    {
        return $this->state(fn (array $attributes) => [
            'product_id' => $product->id,
            'unit_price' => $product->price, // Use actual product price
        ]);
    }

    public function withQuantity(int $quantity): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => $quantity,
        ]);
    }

    public function withPrice(float $price): static
    {
        return $this->state(fn (array $attributes) => [
            'unit_price' => $price,
        ]);
    }

    public function singleItem(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 1,
        ]);
    }

    public function multipleItems(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => $this->faker->numberBetween(2, 10),
        ]);
    }

    public function expensiveItem(): static
    {
        return $this->state(fn (array $attributes) => [
            'unit_price' => $this->faker->randomFloat(2, 100, 500),
        ]);
    }

    public function budgetItem(): static
    {
        return $this->state(fn (array $attributes) => [
            'unit_price' => $this->faker->randomFloat(2, 5, 50),
        ]);
    }
}
