<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_index()
    {
        $product = Product::factory()->count(5)->create();

        $response = $this->json('GET', '/api/products');

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json')
            ->assertJsonCount(5);
    }

    public function test_create_new_product()
    {
        $data = [
            'nombre' => 'Comida don Kat',
            'precio' => 9000,
        ];
        $response = $this->json('POST', '/api/products', $data);

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');

        $this->assertDatabaseHas('products', $data);
    }

    public function test_update_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $data = [
            'nombre' => 'Update Product',
            'precio' => 20000,
        ];

        $response = $this->patchJson("/api/products/{$product->getKey()}", $data);
        $response->assertSuccessful();
    }

    public function test_show_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();;

        $response = $this->json('GET', "/api/products/{$product->getKey()}");

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');
    }

    public function test_delete_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->getKey()}");

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');

        $this->assertDeleted($product);
    }
}

