<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\ReviewsProduct as Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {

    $store_id = rand(1, 3);
    $product_id = rand(1, 30);
    $customer_name = $faker->sentence(rand(1, 3), true);
    $customer_email = $faker->unique()->safeEmail;
    $review = $faker->realText(rand(50, 100));
    $input = [
        10,
        20,
        30,
        40,
        50
    ];
    $rand_keys = array_rand($input);
    $rating = $input[$rand_keys];
    $createdAt = $faker->dateTimeBetween('-2 month', '-1 month');

    $data = [
        'store_id' => $store_id,
        'product_id' => $product_id,
        'customer_name' => $customer_name,
        'customer_email' => $customer_email,
        'review' => $review,
        'rating' => $rating,
        'published' => true,
        'created_at' => $createdAt,
        'updated_at' => $createdAt
    ];

    return $data;
});
