<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['primary', 'success', 'danger', 'warning', 'info'])],
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'action_url' => ['nullable', 'string', 'max:500'],
            'action_text' => ['nullable', 'string', 'max:100'],
            'is_read' => ['boolean'],
        ];
    }
}
