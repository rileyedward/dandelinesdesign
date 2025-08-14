<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostRequest extends FormRequest
{
    public function rules(): array
    {
        $blogPostId = $this->route('id');
        $isUpdate = $this->isMethod('patch') || $this->isMethod('put');

        return [
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'image_url' => ['nullable', 'string', 'url'],
            'is_published' => ['boolean'],
        ];
    }
}
