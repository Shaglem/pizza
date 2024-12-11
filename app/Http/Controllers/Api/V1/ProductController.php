<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Product\IndexProductAction;
use App\Actions\Product\ShowProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\IndexProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(IndexProductAction $action, IndexProductRequest $request): AnonymousResourceCollection
    {
        return ProductResource::collection($action->handle($request));
    }

    public function show(ShowProductAction $action, Product $product): ProductResource
    {
        return new ProductResource($action->handle($product));
    }
}
