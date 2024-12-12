<?php

namespace App\Rules;

use App\Models\Category;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxQuantityOfProductsInBasketIsNotExceedRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = [];

        foreach ($value as $item) {
            $categoryId = Product::find($item['product_id'])?->category?->id;

            if (!$categoryId) {
                $fail("Передан неверный идентификатор товара");
                return;
            }

            if(array_key_exists($categoryId, $data)) {
                $data[$categoryId] += $item['product_quantity'];
                continue;
            };

            $data[$categoryId] = $item['product_quantity'];
        }

        foreach ($data as $key => $item) {
            $category = Category::find($key);

            if ($category->product_max_quantity < $item) {
                $fail("Первышено максимальное количество продуктов категории '$category->title'");
                return;
            }
        }
    }
}
