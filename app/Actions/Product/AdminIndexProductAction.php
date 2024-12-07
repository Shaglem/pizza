<?php

namespace App\Actions\Product;


use App\Http\Requests\Product\AdminIndexProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminIndexProductAction
{
    public function handle(AdminIndexProductRequest $request): LengthAwarePaginator
    {
        return Product::with('category')
                        ->paginate(perPage:$request->first ?? 10, page:$request->page ?? 1);
    }
}
