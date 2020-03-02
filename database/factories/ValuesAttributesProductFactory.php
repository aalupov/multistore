<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ValuesAttributesProduct as Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    $attribute_id = rand(1, 20);
    $attribute_value = rand(10, 50);
    $createdAt = $faker->dateTimeBetween('-2 month', '-1 month');
    
    $data = [
        'attribute_id' => $attribute_id,
        'attribute_value' => $attribute_value,
        'created_at' => $createdAt,
        'updated_at' => $createdAt
    ];
    return $data;
});
