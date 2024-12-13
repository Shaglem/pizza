<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Order\IndexOrderAction;
use App\Actions\Order\StoreOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\IndexOrderRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function index(IndexOrderRequest $request, IndexOrderAction $action): AnonymousResourceCollection
    {
        return OrderResource::collection($action->handle($request));
    }

    public function store(StoreOrderRequest $request, StoreOrderAction $action): OrderResource
    {
        return new OrderResource($action->handle($request));
    }
}
