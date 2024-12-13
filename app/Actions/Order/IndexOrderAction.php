<?php

namespace App\Actions\Order;


use App\Http\Requests\Order\IndexOrderRequest;
use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexOrderAction
{
    public function handle(IndexOrderRequest $request): LengthAwarePaginator
    {
        return Order::currentUser()
            ->with('user')
            ->paginate(perPage:$request->first ?? 10, page:$request->page ?? 1);
    }
}
