<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\StoresTimeShedule as Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {

    $store_id = rand(1, 3);
    $day_of_week = rand(1, 7);
    $createdAt = $faker->dateTimeBetween('-4 month', '-3 month');

    $data = [
        'store_id' => $store_id,
        'day_of_week' => $day_of_week,
        'opened_at' => '1970-01-01 10:00:00',
        'closed_at' => '1970-01-01 18:00:00',
        'time_zone' => 'America/New_york',
        'created_at' => $createdAt,
        'updated_at' => $createdAt
    ];
    return $data;
});
