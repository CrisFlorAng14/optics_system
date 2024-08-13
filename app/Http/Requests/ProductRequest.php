<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'name_product' => 'required|string|max:100',
			'brand' => 'required|string|max:50',
			'category' => 'required|string|max:50',
			'price' => 'required|numeric',
			'stock' => 'required|integer',
			'description' => 'nullable|string',
			'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ];
    }
}
