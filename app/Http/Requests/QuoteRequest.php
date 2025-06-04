<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'event_date' => ['required', 'date', 'after:today'],
            'event_type' => ['required', 'string', 'max:255'],
            'event_description' => ['required', 'string'],
            'guest_count' => ['required', 'integer', 'min:1'],
            'venue_name' => ['nullable', 'string', 'max:255'],
            'venue_address' => ['required', 'string', 'max:255'],
            'budget_range' => ['required', 'string', 'max:255'],
            'special_requests' => ['nullable', 'string'],
        ];
    }
}
