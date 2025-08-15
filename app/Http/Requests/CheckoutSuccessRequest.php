<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutSuccessRequest extends FormRequest
{
    public function rules(): array
    {
//        return [
//            'session_id' => 'required|string|starts_with:cs_',
//        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
//        return [
//            'session_id.required' => 'Checkout session ID is required.',
//            'session_id.starts_with' => 'Invalid checkout session ID format.',
//        ];
    }
}
