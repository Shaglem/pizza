<?php

namespace App\Actions\BasketItem;


use App\Models\BasketItem;
use Illuminate\Support\Facades\Gate;

class DeleteBasketItemAction
{
    public function handle(BasketItem $basketItem): void
    {
        Gate::authorize('delete', $basketItem);

        $basketItem->delete();
    }
}
