<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        $productId = $this->route('id');
        $isUpdate = $this->isMethod('patch') || $this->isMethod('put');

        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
