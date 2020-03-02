<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CategoryProductsRelationships as Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {

    $store_id = rand(1, 3);
    $category_id = rand(1, 10);
    $product_id = rand(1, 30);
    $createdAt = $faker->dateTimeBetween('-2 month', '-1 month');
    
    $data = [
        'store_id' => $store_id,
        'category_id' => $category_id,
        'product_id' => $product_id,
        'created_at' => $createdAt,
        'updated_at' => $createdAt
    ];
    
    return $data;
});
