<?php

namespace App\Actions\Product;


use App\Http\Requests\Product\IndexProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexProductAction
{
    public function handle(IndexProductRequest $request): LengthAwarePaginator
    {
        return Product::with('category')
                        ->paginate(perPage:$request->first ?? 10, page:$request->page ?? 1);
    }
}
