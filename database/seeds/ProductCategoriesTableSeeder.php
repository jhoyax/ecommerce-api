<?php

use App\Eloquent\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ProductCategory::class, 4)->create()->each(function($product_category) {
            $product_category->addMedia(storage_path('images/product-categories/' . $product_category->id . '.jpg'))->toMediaCollection('images');
        });
    }
}
