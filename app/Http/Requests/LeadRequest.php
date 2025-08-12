<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeadRequest extends FormRequest
{
    public function rules(): array
    {
        $leadId = $this->route('id');
        $isUpdate = $this->isMethod('patch') || $this->isMethod('put');

        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                Rule::unique('leads', 'email')->ignore($isUpdate ? $leadId : null),
            ],
            'phone_number' => ['nullable', 'string'],
            'company' => ['nullable', 'string'],
            'status' => ['nullable', Rule::in(['new', 'contacted', 'qualified', 'proposal', 'won', 'lost'])],
            'source' => ['nullable', Rule::in(['website', 'referral', 'social_media', 'advertising', 'other'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}
