<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Eloquent\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
    $title = $faker->sentence(3);
    return [
        'title' => $title,
        'slug' => ProductCategory::generateSlug($title),
        'description' => $faker->text(),
    ];
});
