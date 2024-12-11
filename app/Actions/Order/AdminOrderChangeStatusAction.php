<?php

namespace App\Actions\Order;


use App\Http\Requests\Order\AdminOrderChangeStatusRequest;
use App\Models\Order;

class AdminOrderChangeStatusAction
{
    public function handle(AdminOrderChangeStatusRequest $request, Order $order): Order
    {
        $order->status = $request->validated()['status'];

        $order->save();

        return $order;
    }
}
