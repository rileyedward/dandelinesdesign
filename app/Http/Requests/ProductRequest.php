<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        $productId = $this->route('id');
        $isUpdate = $this->isMethod('patch') || $this->isMethod('put');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string'],
            'slug' => [
                'required',
                'string',
                Rule::unique('products', 'slug')->ignore($isUpdate ? $productId : null),
            ],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image_url' => ['nullable', 'url'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
        ];
    }
}
