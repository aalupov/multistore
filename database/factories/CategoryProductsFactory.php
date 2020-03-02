<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\CategoryProducts as Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    $store_id = rand(1, 3);
    $name = $faker->sentence(rand(1, 3), true);
    $createdAt = $faker->dateTimeBetween('-3 month', '-1 month');

    $data = [
        'store_id' => $store_id,
        'parent_id' => null,
        'category_name' => $name,
        'created_at' => $createdAt,
        'updated_at' => $createdAt
    ];
    
    return $data;
});
