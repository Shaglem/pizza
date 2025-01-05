<?php

namespace Tests\Feature;

use App\Models\BasketItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_authenticated_user_can_fetch_orders()
    {
        $user = User::factory()->create();
        Order::factory(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'user_id', 'status', 'price', 'delivery_time', 'delivery_address', 'customer_phone'],
                ],
                'meta' => ['current_page', 'last_page', 'from', 'to', 'per_page', 'total'],
                'links' => ['first', 'last', 'prev', 'next'],
            ]);

        $this->assertCount(5, $response->json('data'));
    }

    public function test_authenticated_user_can_create_order()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100]);
        BasketItem::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_quantity' => 2,
        ]);

        $data = [
            'customer_phone' => '+12345678901',
            'delivery_time' => now()->addDay()->format('Y-m-d H:i:s'),
            'delivery_address' => '123 Test Street',
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/orders', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'user_id', 'status', 'price', 'delivery_time', 'delivery_address', 'customer_phone'],
            ])
            ->assertJsonPath('data.price', 200);
    }

    public function test_order_creation_fails_validation()
    {
        $user = User::factory()->create();
        $data = [
            'customer_phone' => 'invalid_phone',
            'delivery_time' => 'invalid_date',
            'delivery_address' => '',
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/orders', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['customer_phone', 'delivery_time', 'delivery_address']);
    }

    public function test_unauthenticated_user_cannot_create_order()
    {
        $data = [
            'customer_phone' => '+12345678901',
            'delivery_time' => now()->addDay()->format('Y-m-d H:i:s'),
            'delivery_address' => '123 Test Street',
        ];

        $response = $this->postJson('/api/v1/orders', $data);

        $response->assertStatus(401);
    }
}
