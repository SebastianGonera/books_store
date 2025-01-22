<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'status'=> 'required|in:pending,processing,delivered,cancelled',
            'total_price'=> 'required|numeric|min:10',
        ];

        if($this->isMethod('post')){
            $rules = array_merge($rules, [
                'user_id'=> 'required|exists:users,id',
            ]);
        }

        return $rules;
    }
}
