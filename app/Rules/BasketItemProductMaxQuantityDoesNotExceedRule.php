<?php

namespace App\Rules;

use App\Models\BasketItem;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BasketItemProductMaxQuantityDoesNotExceedRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productCategory = Product::find($value)->category;

        $quantityOfProducts = $this->getQuantityOfProductsInCurrentUserBasketByProductCategoryId($productCategory->id);

        if ($productCategory->product_max_quantity <= $quantityOfProducts) {
            $fail("Добавлено максимальное количество товаров данной категории");
        }
    }

    private function getQuantityOfProductsInCurrentUserBasketByProductCategoryId(int $categoryId): int
    {
        return (integer) BasketItem::currentUser()
            ->whereRelation('product.category', 'id', $categoryId)
            ->with('product')
            ->sum('product_quantity');
    }
}
