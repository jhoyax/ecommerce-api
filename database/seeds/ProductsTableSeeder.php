<?php

use App\Eloquent\Product;
use App\Eloquent\ProductCategory;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 25)->create()->each(function ($product) {
            $product->addMedia(storage_path('images/products/' . $product->id . '.jpg'))->toMediaCollection('images');

            $productCategory = ProductCategory::where('product_category_id', '>', 1)->inRandomOrder()->first();
            $productCategory->addProduct($product);
        });
    }
}
