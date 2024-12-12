<?php

namespace App\Actions\BasketItem;


use App\Http\Requests\BasketItem\BulkStoreBasketItemRequest;
use App\Models\BasketItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BulkStoreBasketItemAction
{
    public function handle(BulkStoreBasketItemRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = Auth::user();

        DB::beginTransaction();

        $user->basketItems()->delete();

        foreach ($data['items'] as $item) {
            $item['user_id'] = $user->id;

            BasketItem::create($item);
        }

        DB::commit();

        return response()->json(['message' => 'Basket updated successfully.'], 200);
    }
}
