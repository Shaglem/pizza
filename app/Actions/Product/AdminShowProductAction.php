<?php

namespace App\Actions\Product;


use App\Http\Requests\Product\AdminIndexProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminShowProductAction
{
    public function handle(Product $product): Product
    {
        return $product->load('category');
    }
}
