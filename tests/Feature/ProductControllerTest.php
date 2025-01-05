<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_can_fetch_paginated_list_of_products()
    {
        Product::factory(15)->create();

        $response = $this->getJson('/api/v1/products?first=5&page=1');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'description', 'price', 'weight', 'image_link', 'category_id', 'category'],
                ],
                'meta' => ['current_page', 'last_page', 'from', 'to', 'per_page', 'total'],
                'links' => ['first', 'last', 'prev', 'next'],
            ]);

        $this->assertCount(5, $response->json('data'));
    }

    public function test_can_fetch_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/v1/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'title', 'description', 'price', 'weight', 'image_link', 'category_id', 'category'],
            ])
            ->assertJsonPath('data.id', $product->id);
    }

    public function test_cannot_fetch_nonexistent_product()
    {
        $response = $this->getJson('/api/v1/products/999999');

        $response->assertStatus(404);
    }
}
