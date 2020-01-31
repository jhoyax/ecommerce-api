<?php

namespace Tests\Feature\API;

use App\Eloquent\ProductCategory;
use Illuminate\Http\Response;
use Tests\TestCaseAPI;
use Tests\Traits\RefreshDatabaseWithSeeds;

class ProductCategoriesTest extends TestCaseAPI
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
            'title' => 'Sports',
            'slug' => 'sports',
        ];

        $this->signInAsAdmin();

        $this->postJson($this->path('products/categories'), $data)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'description',
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
        $productCategory = factory(ProductCategory::class)->create();

        $data = [
            'title' => 'Foods',
        ];

        $this->signInAsAdmin();

        $this->patchJson($this->path('products/categories/' . $productCategory->slug), $data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'id' => true,
                    'title' => 'Foods',
                    'slug' => true,
                    'description' => true,
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
        $productCategory = factory(ProductCategory::class)->create();

        $this->signInAsAdmin();

        $this->deleteJson($this->path('products/categories/' . $productCategory->slug))
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Product Generate Slug
     *
     * @return void
     */
    public function testProductGenerateSlug()
    {
        $this->getJson($this->path('products/categories/generate-slug?title=Life and Health'))
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'slug' => 'life-and-health'
            ]);
    }
}
