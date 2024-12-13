<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'customer_phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'delivery_time' => 'required|date_format:Y-m-d H:i:s',
            'delivery_address' => 'required|string|max:255',
        ];
    }
}
