<?php

namespace App\Actions\Product;


use App\Models\Product;

class ShowProductAction
{
    public function handle(Product $product): Product
    {
        return $product->load('category');
    }
}
