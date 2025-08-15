<?php

namespace App\Http\Requests;

use App\Models\Price;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.price_id' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $price = Price::query()->where('stripe_price_id', $value)->first();
                    if (! $price) {
                        $fail('The selected price is invalid.');
                    } elseif (! $price->active) {
                        $fail('The selected price is no longer available.');
                    }
                },
            ],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'You must select at least one item.',
            'items.min' => 'You must select at least one item.',
            'items.*.price_id.required' => 'Price ID is required for each item.',
            'items.*.quantity.required' => 'Quantity is required for each item.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'items.*.quantity.max' => 'Quantity cannot exceed 99.',
        ];
    }

    public function attributes(): array
    {
        return [
            'items' => 'cart items',
            'items.*.price_id' => 'price ID',
            'items.*.quantity' => 'quantity',
        ];
    }
}
