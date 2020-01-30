<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Eloquent\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $title = $faker->sentence(3);
    return [
        'title' => $title,
        'slug' => Product::generateSlug($title),
        'description' => $faker->text(),
        'price' => $faker->randomNumber(2),
        'stock' => 100,
        'discount' => 0,
    ];
});
