<?php

namespace App\Actions\Order;


use App\Http\Requests\Order\AdminIndexOrderRequest;
use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminIndexOrderAction
{
    public function handle(AdminIndexOrderRequest $request): LengthAwarePaginator
    {
        return Order::with('user')
                      ->paginate(perPage:$request->first ?? 10, page:$request->page ?? 1);
    }
}
