<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'User',
                'email' => 'user@example.com',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'is_admin' => true,
            ],
        ]);

        Category::insert([
            ['title' => 'Pizza', 'product_max_quantity' => 10],
            ['title' => 'Drink', 'product_max_quantity' => 20],
        ]);

        // Получение идентификаторов категорий
        $pizzaCategoryId = Category::where('title', 'Pizza')->first()->id;
        $drinkCategoryId = Category::where('title', 'Drink')->first()->id;

        // Создание продуктов
        Product::insert([
            // Продукты для категории Pizza
            ['title' => 'Margherita', 'description' => 'Classic Italian pizza', 'price' => 8.99, 'weight' => 500, 'image_link' => 'margherita.jpg', 'category_id' => $pizzaCategoryId],
            ['title' => 'Pepperoni', 'description' => 'Spicy pepperoni and cheese', 'price' => 9.99, 'weight' => 550, 'image_link' => 'pepperoni.jpg', 'category_id' => $pizzaCategoryId],
            ['title' => 'Four Cheese', 'description' => 'A blend of four cheeses', 'price' => 10.99, 'weight' => 600, 'image_link' => 'four_cheese.jpg', 'category_id' => $pizzaCategoryId],
            ['title' => 'Hawaiian', 'description' => 'Ham and pineapple', 'price' => 11.99, 'weight' => 580, 'image_link' => 'hawaiian.jpg', 'category_id' => $pizzaCategoryId],
            ['title' => 'Veggie', 'description' => 'Vegetarian pizza with fresh vegetables', 'price' => 7.99, 'weight' => 520, 'image_link' => 'veggie.jpg', 'category_id' => $pizzaCategoryId],
            ['title' => 'BBQ Chicken', 'description' => 'Chicken with BBQ sauce', 'price' => 12.99, 'weight' => 650, 'image_link' => 'bbq_chicken.jpg', 'category_id' => $pizzaCategoryId],
            ['title' => 'Meat Lovers', 'description' => 'Loaded with various meats', 'price' => 13.99, 'weight' => 700, 'image_link' => 'meat_lovers.jpg', 'category_id' => $pizzaCategoryId],
            ['title' => 'Seafood', 'description' => 'Pizza with shrimp and other seafood', 'price' => 14.99, 'weight' => 620, 'image_link' => 'seafood.jpg', 'category_id' => $pizzaCategoryId],
            ['title' => 'Spinach and Feta', 'description' => 'Spinach and feta cheese', 'price' => 8.99, 'weight' => 540, 'image_link' => 'spinach_feta.jpg', 'category_id' => $pizzaCategoryId],
            ['title' => 'Buffalo Chicken', 'description' => 'Spicy chicken pizza', 'price' => 11.99, 'weight' => 600, 'image_link' => 'buffalo_chicken.jpg', 'category_id' => $pizzaCategoryId],

            // Продукты для категории Drink
            ['title' => 'Cola', 'description' => 'Classic cola drink', 'price' => 1.99, 'weight' => 500, 'image_link' => 'cola.jpg', 'category_id' => $drinkCategoryId],
            ['title' => 'Orange Juice', 'description' => 'Freshly squeezed orange juice', 'price' => 2.99, 'weight' => 300, 'image_link' => 'orange_juice.jpg', 'category_id' => $drinkCategoryId],
            ['title' => 'Lemonade', 'description' => 'Refreshing lemonade', 'price' => 2.49, 'weight' => 400, 'image_link' => 'lemonade.jpg', 'category_id' => $drinkCategoryId],
            ['title' => 'Iced Tea', 'description' => 'Chilled iced tea', 'price' => 2.49, 'weight' => 450, 'image_link' => 'iced_tea.jpg', 'category_id' => $drinkCategoryId],
            ['title' => 'Water', 'description' => 'Still mineral water', 'price' => 0.99, 'weight' => 500, 'image_link' => 'water.jpg', 'category_id' => $drinkCategoryId],
            ['title' => 'Sparkling Water', 'description' => 'Carbonated mineral water', 'price' => 1.49, 'weight' => 500, 'image_link' => 'sparkling_water.jpg', 'category_id' => $drinkCategoryId],
            ['title' => 'Energy Drink', 'description' => 'Boost your energy', 'price' => 2.99, 'weight' => 330, 'image_link' => 'energy_drink.jpg', 'category_id' => $drinkCategoryId],
            ['title' => 'Smoothie', 'description' => 'Fruit smoothie', 'price' => 3.99, 'weight' => 350, 'image_link' => 'smoothie.jpg', 'category_id' => $drinkCategoryId],
            ['title' => 'Milkshake', 'description' => 'Creamy milkshake', 'price' => 3.49, 'weight' => 400, 'image_link' => 'milkshake.jpg', 'category_id' => $drinkCategoryId],
            ['title' => 'Hot Chocolate', 'description' => 'Warm chocolate drink', 'price' => 2.99, 'weight' => 300, 'image_link' => 'hot_chocolate.jpg', 'category_id' => $drinkCategoryId],
        ]);
    }
}
