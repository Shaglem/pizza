<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\BasketItem\DeleteBasketItemAction;
use App\Actions\BasketItem\IndexBasketItemAction;
use App\Actions\BasketItem\StoreBasketItemAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BasketItem\IndexBasketItemRequest;
use App\Http\Requests\BasketItem\StoreBasketItemRequest;
use App\Http\Resources\BasketItemResource;
use App\Models\BasketItem;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BasketItemController extends Controller
{
    public function index(IndexBasketItemRequest $request, IndexBasketItemAction $action): AnonymousResourceCollection
    {
        return BasketItemResource::collection($action->handle($request));
    }

    public function store(StoreBasketItemRequest $request, StoreBasketItemAction $action): BasketItemResource
    {
        return new BasketItemResource($action->handle($request));
    }

    public function destroy(DeleteBasketItemAction $action, BasketItem $basketItem): Response
    {
        $action->handle($basketItem);

        return response()->noContent();
    }
}
