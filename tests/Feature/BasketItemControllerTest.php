<?php

namespace Tests\Feature;

use App\Models\BasketItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasketItemControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_authenticated_user_can_view_basket_items()
    {
        $user = User::factory()->create();
        BasketItem::factory(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/basket-items');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'product_id', 'product_quantity', 'product']
                ]
            ]);
    }

    public function test_unauthenticated_user_cannot_view_basket_items()
    {
        $response = $this->getJson('/api/v1/basket-items');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_add_product_to_basket()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'product_id' => $product->id,
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/basket-items', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'product_id', 'product_quantity', 'product']
            ])
            ->assertJsonPath('data.product_id', $product->id)
            ->assertJsonPath('data.product_quantity', 1);
    }

    public function test_user_cannot_add_nonexistent_product_to_basket()
    {
        $user = User::factory()->create();

        $data = [
            'product_id' => 99999999,
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/basket-items', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id']);
    }

    public function test_authenticated_user_can_remove_product_from_basket()
    {
        $user = User::factory()->create();
        $basketItem = BasketItem::factory()->create([
            'user_id' => $user->id,
            'product_quantity' => 1,
        ]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/v1/basket-items/{$basketItem->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('basket_items', ['id' => $basketItem->id]);
    }

    public function test_authenticated_user_cannot_remove_basket_item_of_another_user()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $basketItem = BasketItem::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/v1/basket-items/{$basketItem->id}");

        $response->assertStatus(403);
    }

    public function test_authenticated_user_can_bulk_store_basket_items()
    {
        $user = User::factory()->create();
        $products = Product::factory(3)->create();

        $data = [
            'items' => [
                ['product_id' => $products[0]->id, 'product_quantity' => 2],
                ['product_id' => $products[1]->id, 'product_quantity' => 3],
                ['product_id' => $products[2]->id, 'product_quantity' => 1],
            ],
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/basket-items/bulk-store', $data);

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Basket updated successfully.');

        // Проверяем, что данные добавлены в базу
        $this->assertDatabaseHas('basket_items', [
            'user_id' => $user->id,
            'product_id' => $products[0]->id,
            'product_quantity' => 2,
        ]);

        $this->assertDatabaseHas('basket_items', [
            'user_id' => $user->id,
            'product_id' => $products[1]->id,
            'product_quantity' => 3,
        ]);

        $this->assertDatabaseHas('basket_items', [
            'user_id' => $user->id,
            'product_id' => $products[2]->id,
            'product_quantity' => 1,
        ]);
    }

    public function test_bulk_store_fails_with_invalid_product_id()
    {
        $user = User::factory()->create();

        $data = [
            'items' => [
                ['product_id' => 999999, 'product_quantity' => 2], // Несуществующий продукт
            ],
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/basket-items/bulk-store', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items.0.product_id']);
    }

}
