<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsletterSubscriberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $subscriberId = $this->route('id');
        $isUpdate = $this->isMethod('patch') || $this->isMethod('put');

        return [
            'email' => [
                'required',
                'email',
                Rule::unique('newsletter_subscribers', 'email')->ignore($isUpdate ? $subscriberId : null),
            ],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive', 'unsubscribed'])],
            'subscribed_at' => ['nullable', 'date'],
            'unsubscribed_at' => ['nullable', 'date'],
            'source' => ['nullable', 'string', 'max:255'],
            'preferences' => ['nullable', 'array'],
            'tags' => ['nullable', 'array'],
        ];
    }
}
