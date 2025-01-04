<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_admin_can_view_products_list()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Product::factory(3)->create();

        $response = $this->actingAs($admin)->getJson('/api/v1/admin/products');

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_view_products_list()
    {
        $response = $this->getJson('/api/v1/admin/products');

        $response->assertStatus(403); // Unauthorized
    }


    public function test_admin_can_create_product()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $data = [
            'title' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100,
            'weight' => 500,
            'image_link' => 'SosalEbal.ru',
            'category_id' => Category::first()->id,
        ];

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/products', $data);


        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'Test Product');
    }

    public function test_admin_cannot_create_product_with_invalid_data()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $data = [
            'title' => '',
            'price' => -50,
        ];

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/products', $data);

        $response->assertStatus(422);
    }

    public function test_admin_can_update_product()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $product = Product::factory()->create();

        $data = [
            'title' => 'Updated Product Title',
            'description' => 'Updated Product Description',
            'weight' => 500,
            'category_id' => Category::first()->id,
            'price' => 200.22,
        ];

        $response = $this->actingAs($admin)->putJson("/api/v1/admin/products/{$product->id}", $data);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Product Title');
    }

    public function test_admin_cannot_update_product_with_invalid_data()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $product = Product::factory()->create();

        $data = [
            'title' => '',
            'price' => 'invalid',
        ];

        $response = $this->actingAs($admin)->putJson("/api/v1/admin/products/{$product->id}", $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'price']);
    }

    public function test_admin_can_view_single_product()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $product = Product::factory()->create();

        $response = $this->actingAs($admin)->getJson("/api/v1/admin/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $product->id);
    }

    public function test_admin_cannot_view_nonexistent_product()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->getJson('/api/v1/admin/products/99999');

        $response->assertStatus(404);
    }

    public function test_admin_can_delete_product()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $product = Product::factory()->create();

        $response = $this->actingAs($admin)->delete("/api/v1/admin/products/{$product->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_admin_cannot_delete_nonexistent_product()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->deleteJson('/api/v1/admin/products/99999');

        $response->assertStatus(404);
    }

}
