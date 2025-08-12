<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuoteRequestRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone_number' => ['nullable', 'string'],
            'service_type' => ['required', Rule::in(['floral_design', 'event_planning', 'both'])],
            'event_date' => ['nullable', 'date'],
            'event_location' => ['nullable', 'string'],
            'guest_count' => ['nullable', 'integer', 'min:1'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'status' => ['nullable', Rule::in(['pending', 'contacted', 'quoted', 'completed', 'cancelled'])],
        ];
    }
}
