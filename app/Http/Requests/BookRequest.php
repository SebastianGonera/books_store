<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => 'required|min:3|max:100',
            'author' => 'required|min:3|max:100',
            'description' => 'required|min:10|max:200',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'image_url' => 'required|url',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
