<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Stores;
use Faker\Generator as Faker;
use Faker\Factory as FakerUs;

$factory->define(Stores::class, function (Faker $faker) {
    $title = $faker->sentence(rand(1, 3), true);
    $fakerUs = FakerUs::create();
    $city = $fakerUs->city;
    $state = $fakerUs->stateAbbr;
    $phone = $fakerUs->e164PhoneNumber;
    $address = $fakerUs->address;
    $zip_code = $fakerUs->postcode;
    $txt = $faker->realText(rand(100, 400));
    $lat = $fakerUs->latitude;
    $lon = $fakerUs->longitude;
    $createdAt = $faker->dateTimeBetween('-3 month', '-1 month');

    
    $data = [
        'store_title' => $title,
        'store_description' => $txt,
        'store_is_activated' => 1,
        'store_email' => $faker->unique()->safeEmail,
        'store_country' => 'USA',
        'store_zip' => $zip_code,
        'store_state' => $state,
        'store_city' => $city,
        'store_phone' => $phone,
        'store_address' => $address,
        'store_picture' => 'test_store_picture.jpg',
        'store_lat' => $lat,
        'store_lon' => $lon,
        'created_at' => $createdAt,
        'updated_at' => $createdAt
    ];
    return $data;
});
