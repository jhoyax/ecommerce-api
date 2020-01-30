<?php

namespace Tests\Feature\API;

use App\Eloquent\Product;
use Illuminate\Http\Response;
use Tests\TestCaseAPI;
use Tests\Traits\RefreshDatabaseWithSeeds;

class ProductsTest extends TestCaseAPI
{
    use RefreshDatabaseWithSeeds;

    /**
     * Store Product
     *
     * @return void
     */
    public function testStoreProduct()
    {
        $data = [
            'title' => 'Product 1',
            'slug' => 'product-1',
            'price' => 50,
        ];

        $this->signInAsAdmin();

        $this->postJson($this->path('products'), $data)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'description',
                    'price',
                    'stock',
                    'discount',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /**
     * Update Product
     *
     * @return void
     */
    public function testUpdateProduct()
    {
        $product = factory(Product::class)->create();

        $data = [
            'title' => 'Product One',
            'price' => 345.50
        ];

        $this->signInAsAdmin();

        $this->patchJson($this->path('products/' . $product->slug), $data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'id' => true,
                    'title' => 'Product One',
                    'slug' => true,
                    'description' => true,
                    'price' => 345.50,
                    'stock' => true,
                    'discount' => true,
                    'created_at' => true,
                    'updated_at' => true,
                ]
            ]);
    }

    /**
     * Delete Product
     *
     * @return void
     */
    public function testDeleteProduct()
    {
        $product = factory(Product::class)->create();

        $this->signInAsAdmin();

        $this->deleteJson($this->path('products/' . $product->slug))
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Product Generate Slug
     *
     * @return void
     */
    public function testProductGenerateSlug()
    {
        $this->getJson($this->path('products/generate-slug?title=Mouse pad'))
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'slug' => 'mouse-pad'
            ]);
    }
}
