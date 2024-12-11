<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Order\AdminIndexOrderAction;
use App\Actions\Order\AdminOrderChangeStatusAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\AdminIndexOrderRequest;
use App\Http\Requests\Order\AdminOrderChangeStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminOrderController extends Controller
{
    public function index(AdminIndexOrderRequest $request, AdminIndexOrderAction $action): AnonymousResourceCollection
    {
        return OrderResource::collection($action->handle($request));
    }
    public function changeStatus(AdminOrderChangeStatusRequest $request, AdminOrderChangeStatusAction $action, Order $order): OrderResource
    {
        return new OrderResource($action->handle($request, $order));
    }
}
