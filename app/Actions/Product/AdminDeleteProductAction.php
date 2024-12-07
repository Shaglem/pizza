<?php

namespace App\Actions\Product;


use App\Models\Product;

class AdminDeleteProductAction
{
    public function handle(Product $product): void
    {
        $product->delete();
    }
}
