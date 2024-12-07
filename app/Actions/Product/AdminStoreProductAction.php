<?php

namespace App\Actions\Product;


use App\Http\Requests\Product\AdminStoreAndUpdateProductRequest;
use App\Models\Product;

class AdminStoreProductAction
{
    public function handle(AdminStoreAndUpdateProductRequest $request): Product
    {
        $product = Product::create($request->validated());

        return $product->load('category');
    }
}
