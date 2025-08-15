<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            return $this->updateRules();
        }

        return [
            // Customer Information
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_first_name' => ['required', 'string', 'max:255'],
            'customer_last_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],

            // Shipping Address
            'shipping_address_line_1' => ['required', 'string', 'max:255'],
            'shipping_address_line_2' => ['nullable', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_state' => ['required', 'string', 'max:50'],
            'shipping_postal_code' => ['required', 'string', 'max:20'],
            'shipping_country' => ['required', 'string', 'max:2'],

            // Products Array
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => [
                'required',
                'integer',
                'exists:products,id',
                function ($attribute, $value, $fail) {
                    $product = \App\Models\Product::find($value);
                    if ($product && ! $product->is_active) {
                        $fail('The selected product is no longer available.');
                    } elseif ($product && ! $product->isInStock()) {
                        $fail('The selected product is currently out of stock.');
                    }
                },
            ],
            'products.*.quantity' => [
                'required',
                'integer',
                'min:1',
                'max:99',
                function ($attribute, $value, $fail) {
                    $productIndex = explode('.', $attribute)[1];
                    $productId = $this->input("products.{$productIndex}.product_id");

                    if ($productId) {
                        $product = \App\Models\Product::find($productId);
                        if ($product && $value > $product->stock_quantity) {
                            $fail("Only {$product->stock_quantity} items available in stock.");
                        }
                    }
                },
            ],
        ];
    }

    protected function updateRules(): array
    {
        return [
            // Customer Information (admin updatable)
            'customer_email' => ['sometimes', 'email', 'max:255'],
            'customer_first_name' => ['sometimes', 'string', 'max:255'],
            'customer_last_name' => ['sometimes', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],

            // Shipping Address (admin updatable)
            'shipping_address_line_1' => ['sometimes', 'string', 'max:255'],
            'shipping_address_line_2' => ['nullable', 'string', 'max:255'],
            'shipping_city' => ['sometimes', 'string', 'max:100'],
            'shipping_state' => ['sometimes', 'string', 'max:50'],
            'shipping_postal_code' => ['sometimes', 'string', 'max:20'],
            'shipping_country' => ['sometimes', 'string', 'max:2'],
            'shipping_method' => ['nullable', 'string', 'max:100'],

            // Order Status & Tracking (admin updatable)
            'status' => ['sometimes', 'string', 'in:pending,processing,shipped,delivered,cancelled,refunded'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'shipped_at' => ['nullable', 'date'],
            'delivered_at' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => 'You must select at least one product.',
            'products.min' => 'You must select at least one product.',
            'products.*.product_id.required' => 'Product selection is required.',
            'products.*.product_id.exists' => 'Selected product does not exist.',
            'products.*.quantity.required' => 'Product quantity is required.',
            'products.*.quantity.min' => 'Product quantity must be at least 1.',
            'products.*.quantity.max' => 'Product quantity cannot exceed 99.',
            'customer_email.email' => 'Please provide a valid email address.',
            'shipping_address_line_1.required' => 'Shipping address is required.',
            'shipping_city.required' => 'Shipping city is required.',
            'shipping_state.required' => 'Shipping state is required.',
            'shipping_postal_code.required' => 'Shipping postal code is required.',
            'shipping_country.required' => 'Shipping country is required.',
        ];
    }

    public function attributes(): array
    {
        return [
            'customer_email' => 'email address',
            'customer_first_name' => 'first name',
            'customer_last_name' => 'last name',
            'customer_phone' => 'phone number',
            'shipping_address_line_1' => 'street address',
            'shipping_address_line_2' => 'apartment/suite',
            'shipping_city' => 'city',
            'shipping_state' => 'state',
            'shipping_postal_code' => 'postal code',
            'shipping_country' => 'country',
            'customer_notes' => 'order notes',
            'shipping_method' => 'shipping method',
        ];
    }
}
