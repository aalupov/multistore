<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\AttributesProduct as Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {

    $product_id = rand(1, 100);
    $input = [
        'weight',
        'size'
    ];
    $rand_keys = array_rand($input);
    $attribute_name = $input[$rand_keys];
    $createdAt = $faker->dateTimeBetween('-2 month', '-1 month');

    $data = [
        'product_id' => $product_id,
        'attribute_name' => $attribute_name,
        'created_at' => $createdAt,
        'updated_at' => $createdAt
    ];
    return $data;
});
