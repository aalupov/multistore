<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Products as Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {

    $title = $faker->sentence(rand(1, 3), true);
    $slug = Str::slug($title, '-');
    $store_id = rand(1, 3);
    //$category_id = rand(1, 100);
    $createdAt = $faker->dateTimeBetween('-2 month', '-1 month');
    $txt = $faker->realText(rand(50, 150));
    $quantity = rand(0, 50);
    
    $data = [
        'store_id' => $store_id,
      //  'category_id' => $category_id,
        'product_title' => $title,
        'product_sku' => $slug,
        'product_description' => $txt,
        'product_regular_price' => 10.25,
        'product_sale_price' => 8.75,
        'product_type' => 'simple',
        'product_quantity' => $quantity,
        'product_picture' => 'test_product_picture.jpg',
        'created_at' => $createdAt,
        'updated_at' => $createdAt
    ];
    
    return $data;
});
