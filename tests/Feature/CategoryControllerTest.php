<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test_index_categorias()
    {
        $categorias = Category::factory()->count(2)->create();
        $response = $this->json('GET', '/api/categories');
        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json')
            ->assertJsonCount(2);
    }
    /**
     * creacion del test para crear
     * una categoria
     */
     public function test_create_new_category()
     {
         $data = [
            'nombre' => 'Update Category',
            'descripcion' => 'empty value for update'
         ];
        $response = $this->json('POST', '/api/categories', $data);
        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('categories', $data);
     }
    public function test_update_category()
    {
        /** @var Category $product */
        $categoria = Category::factory()->create();

        $data = [
            'nombre' => 'Update Category',
            'descripcion' => 'seamos amantes',
        ];

        $response = $this->patchJson("/api/categories/{$categoria->getKey()}", $data);
        $response->assertSuccessful();
    }

    public function test_show_category()
    {
        /** @var Category $categoria */
        $categoria = Category::factory()->create();;

        $response = $this->json('GET', "/api/categories/{$categoria->getKey()}");

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');
    }

    public function test_delete_category()
    {
        /** @var Category $categoria */
        $categoria = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$categoria->getKey()}");

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');

        $this->assertDeleted($categoria);
    }     
}
