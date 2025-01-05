<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_admin_can_view_orders_list()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Order::factory(5)->create();

        $response = $this->actingAs($admin)->getJson('/api/v1/admin/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'user_id',
                        'status',
                        'price',
                        'delivery_time',
                        'delivery_address',
                        'customer_phone',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta',
                'links',
            ]);
    }

    public function test_unauthenticated_user_cannot_view_orders_list()
    {
        $response = $this->getJson('/api/v1/admin/orders');

        $response->assertStatus(403);
    }

    public function test_admin_cannot_view_orders_list_as_non_admin()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->getJson('/api/v1/admin/orders');

        $response->assertStatus(403);
    }

    public function test_admin_can_change_order_status()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = Order::factory()->create(['status' => Order::CREATED_ORDER_STATUS]);

        $data = ['status' => 'completed'];

        $response = $this->actingAs($admin)->patchJson("/api/v1/admin/order-change-status/{$order->id}", $data);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $order->id)
            ->assertJsonPath('data.status', 'completed');
    }

    public function test_admin_cannot_change_order_status_with_invalid_data()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = Order::factory()->create(['status' => 'created']);

        $data = ['status' => 'invalid_status'];

        $response = $this->actingAs($admin)->patchJson("/api/v1/admin/order-change-status/{$order->id}", $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }

    public function test_admin_cannot_change_status_of_nonexistent_order()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $data = ['status' => 'completed'];

        $response = $this->actingAs($admin)->patchJson('/api/v1/admin/order-change-status/99999', $data);

        $response->assertStatus(404);
    }

    public function test_non_admin_user_cannot_change_order_status()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $order = Order::factory()->create(['status' => 'created']);

        $data = ['status' => 'completed'];

        $response = $this->actingAs($user)->patchJson("/api/v1/admin/order-change-status/{$order->id}", $data);

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_change_order_status()
    {
        $order = Order::factory()->create(['status' => 'created']);

        $data = ['status' => 'completed'];

        $response = $this->patchJson("/api/v1/admin/order-change-status/{$order->id}", $data);

        $response->assertStatus(403);
    }
}
