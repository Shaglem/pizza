<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000), // цена от 10 до 1000 с двумя знаками после запятой
            'weight' => $this->faker->randomFloat(0, 1, 1000), // вес от 1 до 1000 г
            'image_link' => $this->faker->imageUrl(640, 480, 'products'), // случайное изображение товара
            'category_id' => Category::query()->inRandomOrder()->value('id'), // берем случайный id
        ];
    }
}
