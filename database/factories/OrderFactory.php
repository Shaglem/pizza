<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status' => Order::CREATED_ORDER_STATUS,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'delivery_time' => $this->faker->dateTimeBetween('+1 day', '+1 week'),
            'delivery_address' => $this->faker->address,
            'customer_phone' => $this->faker->numerify('+###########'),
        ];
    }
}
