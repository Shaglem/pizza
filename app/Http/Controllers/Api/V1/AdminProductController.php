<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Product\AdminDeleteProductAction;
use App\Actions\Product\AdminIndexProductAction;
use App\Actions\Product\AdminShowProductAction;
use App\Actions\Product\AdminStoreProductAction;
use App\Actions\Product\AdminUpdateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\AdminIndexProductRequest;
use App\Http\Requests\Product\AdminStoreAndUpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class AdminProductController extends Controller
{
    public function index(AdminIndexProductRequest $request, AdminIndexProductAction $action): AnonymousResourceCollection
    {
        return ProductResource::collection($action->handle($request));
    }

    public function show(AdminShowProductAction $action, Product $product): ProductResource
    {
        return new ProductResource($action->handle($product));
    }

    public function store(AdminStoreProductAction $action, AdminStoreAndUpdateProductRequest $request): ProductResource
    {
        return new ProductResource($action->handle($request));
    }

    public function update(AdminUpdateProductAction $action, Product $product, AdminStoreAndUpdateProductRequest $request): ProductResource
    {
        return new ProductResource($action->handle($request, $product));
    }

    public function destroy(AdminDeleteProductAction $action, Product $product): Response
    {
        $action->handle($product);

        return response()->noContent();
    }
}
