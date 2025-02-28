<?php

namespace App\Http\Requests\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class AdminOrderChangeStatusRequest extends FormRequest
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
            'status' => 'required|in:' . implode(',', Order::ORDER_STATUSES)
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Выбранный статус заказа недействителен. Возможные статусы: ' . implode(', ', Order::ORDER_STATUSES) . '.',
        ];
    }

}
