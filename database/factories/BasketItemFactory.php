<?php

namespace Database\Factories;

use App\Models\BasketItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BasketItemFactory extends Factory
{
    protected $model = BasketItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'product_quantity' => $this->faker->numberBetween(1, 10)
        ];
    }
}
