<?php

namespace App\Actions\BasketItem;


use App\Http\Requests\BasketItem\StoreBasketItemRequest;
use App\Models\BasketItem;
use Illuminate\Support\Facades\Auth;

class BulkStoreBasketItemAction
{
    public function handle(StoreBasketItemRequest $request): BasketItem
    {
        $data = $request->validated();

        $productId = (int) $data['product_id'];

        $basketItem = BasketItem::currentUser()
            ->with('product')
            ->firstOrCreate(
                ['product_id' => $productId],
                [
                    'product_quantity' => 1,
                    'user_id' => Auth::id()
                ]
            );

        if (!$basketItem->wasRecentlyCreated) {
            $basketItem->increment('product_quantity');
        }

        return $basketItem->load('product');
    }
}
