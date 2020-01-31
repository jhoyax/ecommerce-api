<?php

namespace Tests\Unit;

use App\Eloquent\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCaseAPI;

class ProductCategoryTest extends TestCaseAPI
{
    use RefreshDatabase;

    /**
     * Generate Slug
     *
     * @return void
     */
    public function testGenerateSlug()
    {
        $title = 'Fashion 101';
        $expectedSlug = 'fashion-101';
        $returnedSlug = ProductCategory::generateSlug($title);
        
        $this->assertEquals($expectedSlug, $returnedSlug);
    }

    /**
     * Generate Slug If It Will Create Unique Slug
     *
     * @return void
     */
    public function testGenerateSlugIfItWillCreateUniqueSlug()
    {
        factory(ProductCategory::class)->create()->each(function ($product) {
            $expectedSlug = $product->slug . '-2';
            $returnedSlug = ProductCategory::generateSlug($product->title);

            $this->assertEquals($expectedSlug, $returnedSlug);
        });
    }
}
