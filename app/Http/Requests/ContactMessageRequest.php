<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'business_name' => ['nullable', 'string'],
            'email' => ['required', 'email'],
            'phone_number' => ['nullable', 'string'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
            'is_read' => ['nullable', 'boolean'],
        ];
    }
}
