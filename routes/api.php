<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('API')->group(function () {
    Route::middleware('guest:airlock')->group(function () {
        Route::post('login', 'LoginController@login')->name('login');
        Route::post('register', 'RegisterController@store')->name('register');

        Route::prefix('products')->group(function () {
            Route::get('/', 'ProductController@index')->name('products.index');
            Route::get('generate-slug', 'GenerateSlugController@createForProduct')->name('products.generate_slug.create');

            Route::prefix('categories')->group(function () {
                Route::get('/', 'ProductCategoryController@index')->name('product_categories.index');
                Route::get('generate-slug', 'GenerateSlugController@createForProductCategory')->name('products.categories.generate_slug.create');

                Route::get('{productCategory}', 'ProductCategoryController@show')->name('product_categories.show');
            });

            Route::get('{product}', 'ProductController@show')->name('products.show');
        });
    });

    Route::middleware('auth:airlock')->group(function () {
        Route::post('logout', 'LoginController@logout')->name('logout');

        Route::prefix('products')->group(function () {
            Route::post('/', 'ProductController@store')->name('products.store');

            Route::prefix('categories')->group(function () {
                Route::post('/', 'ProductCategoryController@store')->name('product_categories.store');
                
                Route::patch('{productCategory}', 'ProductCategoryController@update')->name('product_categories.update');
                Route::delete('{productCategory}', 'ProductCategoryController@destroy')->name('product_categories.destroy');
            });

            Route::patch('{product}', 'ProductController@update')->name('products.update');
            Route::delete('{product}', 'ProductController@destroy')->name('products.destroy');
        });
    });
});
