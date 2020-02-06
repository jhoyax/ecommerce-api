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
        factory(ProductCategory::class, 4)->create()->each(function($productCategory) {
            $productCategory->addMedia(storage_path('images/product-categories/' . $productCategory->id . '.jpg'))->toMediaCollection('images');

            if ($productCategory->id == 2) {
                $firstSubcategory = $productCategory->children()->create([
                    'title' => 'Subcategory 1',
                    'slug' => 'subcategory-1',
                    'description' => 'Lorem ipsum dolor.',
                ]);
                
                $secondSubcategory = $firstSubcategory->children()->create([
                    'title' => 'Subcategory 11',
                    'slug' => 'subcategory-11',
                    'description' => 'Lorem ipsum dolor1.',
                ]);
                
                $firstSubcategory->children()->create([
                    'title' => 'Subcategory 12',
                    'slug' => 'subcategory-12',
                    'description' => 'Lorem ipsum dolor12.',
                ]);
                
                $secondSubcategory->children()->create([
                    'title' => 'Subcategory 111',
                    'slug' => 'subcategory-111',
                    'description' => 'Lorem ipsum dolor1.',
                ]);


                $firstSubcategory = $productCategory->children()->create([
                    'title' => 'Subcategory 2',
                    'slug' => 'subcategory-2',
                    'description' => 'Lorem ipsum dolor.',
                ]);
            }
        });
    }
}
