<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
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
        $rules = [
            'quantity' => 'required|integer|min:1',
            'price' => 'required|decimal:2|min:10',
        ];

        if($this->isMethod('POST')) {
            $rules = array_merge($rules, [
                'order_id' => 'required|integer|exists:orders,id',
                'book_id' => 'required|integer|exists:books,id',
            ]);
        }

        return $rules;
    }
}
