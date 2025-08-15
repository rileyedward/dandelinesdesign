<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LineItem>
 */
class LineItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 5);
        $unitPrice = $this->faker->randomFloat(2, 10, 500);
        $totalPrice = $quantity * $unitPrice;

        return [
            'product_name' => $this->faker->words(3, true),
            'product_sku' => $this->faker->bothify('SKU-###??'),
            'product_description' => $this->faker->sentence(),
            'product_image_url' => $this->faker->imageUrl(400, 400, 'products'),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'currency' => 'USD',
            'stripe_price_id' => $this->faker->bothify('price_#?#?#?#?#?#?'),
            'stripe_product_id' => $this->faker->bothify('prod_#?#?#?#?#?#?'),
        ];
    }
}
