<?php

namespace Tests\Unit;

use App\Eloquent\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCaseAPI;

class ProductTest extends TestCaseAPI
{
    use RefreshDatabase;

    /**
     * Generate Slug
     *
     * @return void
     */
    public function testGenerateSlug()
    {
        $title = 'My first product';
        $expectedSlug = 'my-first-product';
        $returnedSlug = Product::generateSlug($title);
        
        $this->assertEquals($expectedSlug, $returnedSlug);
    }

    /**
     * Generate Slug If It Will Create Unique Slug
     *
     * @return void
     */
    public function testGenerateSlugIfItWillCreateUniqueSlug()
    {
        factory(Product::class)->create()->each(function ($product) {
            $expectedSlug = $product->slug . '-2';
            $returnedSlug = Product::generateSlug($product->title);

            $this->assertEquals($expectedSlug, $returnedSlug);
        });
    }
}
