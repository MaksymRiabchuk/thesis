<?php

namespace App\Http\Requests\Admin\Offers;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'is_published' => ['boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:10240'],
        ];
    }
}