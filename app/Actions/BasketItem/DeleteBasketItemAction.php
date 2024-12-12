<?php

namespace App\Actions\BasketItem;


use App\Models\BasketItem;
use Illuminate\Support\Facades\Gate;

class DeleteBasketItemAction
{
    public function handle(BasketItem $basketItem): void
    {
        Gate::authorize('delete', $basketItem);

        if ($basketItem->product_quantity > 1) {
            $basketItem->decrement('product_quantity', 1);
        } else {
            $basketItem->delete();
        }
    }
}
