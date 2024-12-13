<?php

namespace App\Actions\Order;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class StoreOrderAction
{
    public function handle(StoreOrderRequest $request): Order
    {
        Gate::authorize('create', Order::class);

        $user = Auth::user();
        $data = $request->validated();
        $basketItems = $user->basketItems->load('product');

        DB::beginTransaction();

        // Создаем новый заказ
        $order = Order::create([
            'user_id' => $user->id,
            'delivery_address' => $data['delivery_address'],
            'delivery_time' => $data['delivery_time'],
            'customer_phone' => $data['customer_phone'],
            'status' => 'created',
            'price' => 0,
        ]);

        $totalPrice = 0;

        // Копируем позиции корзины в OrderItem
        foreach ($basketItems as $basketItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $basketItem->product_id,
                'product_quantity' => $basketItem->product_quantity,
                'status' => Order::CREATED_ORDER_STATUS
            ]);

            // Считаем итоговую цену
            $totalPrice += $basketItem->product_quantity * $basketItem->product->price;
        }

        // Обновляем общую стоимость заказа
        $order->update(['price' => $totalPrice]);

        // Удаляем все позиции из корзины пользователя
        $user->basketItems()->delete();

        DB::commit();

        return $order->load('user');

    }
}
