<?php

namespace App\Http\Requests\BasketItem;

use Illuminate\Foundation\Http\FormRequest;

class IndexBasketItemRequest extends FormRequest
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
            'first' => 'nullable|int|max:100',
            'page' => 'nullable|string',
        ];
    }
}
