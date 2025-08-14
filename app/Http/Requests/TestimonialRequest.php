<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'title' => ['nullable', 'string'],
            'quote' => ['required', 'string'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ];
    }
}
