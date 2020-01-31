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
            $product_category = ProductCategory::inRandomOrder()->first();
            $product_category->addProduct($product);
        });
    }
}
