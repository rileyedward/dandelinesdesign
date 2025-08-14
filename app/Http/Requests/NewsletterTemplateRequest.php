<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsletterTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'preview_text' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['draft', 'scheduled', 'sent'])],
            'scheduled_at' => ['nullable', 'date', 'after:now'],
            'sent_at' => ['nullable', 'date'],
            'recipients_count' => ['nullable', 'integer', 'min:0'],
            'opens_count' => ['nullable', 'integer', 'min:0'],
            'clicks_count' => ['nullable', 'integer', 'min:0'],
            'tags' => ['nullable', 'array'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
