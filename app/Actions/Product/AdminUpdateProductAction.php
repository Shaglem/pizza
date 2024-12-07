<?php

namespace App\Actions\Product;


use App\Http\Requests\Product\AdminStoreAndUpdateProductRequest;
use App\Models\Product;

class AdminUpdateProductAction
{
    public function handle(AdminStoreAndUpdateProductRequest $request, Product $product): Product
    {
        $product->update($request->validated());

        return $product->load('category');
    }
}
