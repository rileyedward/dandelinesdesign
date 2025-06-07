<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'event_date' => ['nullable', 'date', 'after:today'],
            'event_type' => ['nullable', 'string', 'max:255'],
            'event_description' => ['required', 'string'],
            'guest_count' => ['nullable', 'integer', 'min:1'],
            'venue_name' => ['nullable', 'string', 'max:255'],
            'venue_address' => ['nullable', 'string', 'max:255'],
            'special_requests' => ['nullable', 'string'],
        ];
    }
}
