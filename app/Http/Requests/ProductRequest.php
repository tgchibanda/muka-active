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
            'title' => ['required', 'max:2000'],
            'weight' => ['required', 'max:2000'],
            'images.*' => ['nullable', 'image'],
            'deleted_images.*' => ['nullable', 'int'],
            'image_positions.*' => ['nullable', 'int'],
            'categories.*' => ['nullable', 'int', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'quantity' => ['nullable', 'numeric', 'min:0'],
            'published' => ['required', 'boolean'],
            'description' => ['nullable', 'string'],
            'product_color' => ['nullable', 'array'], // Ensure it's either null or an array
            'product_color.*' => ['nullable', 'string'], // Each item in the array must be a string
        ]; 
    }
}
