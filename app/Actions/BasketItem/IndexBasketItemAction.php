<?php

namespace App\Actions\BasketItem;


use App\Http\Requests\BasketItem\IndexBasketItemRequest;
use App\Models\BasketItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexBasketItemAction
{
    public function handle(IndexBasketItemRequest $request): LengthAwarePaginator
    {
        return BasketItem::currentUser()
                        ->with('product')
                        ->paginate(perPage:$request->first ?? 10, page:$request->page ?? 1);
    }
}
