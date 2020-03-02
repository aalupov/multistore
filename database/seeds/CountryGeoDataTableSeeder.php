<?php
use Illuminate\Database\Seeder;

class CountryGeoDataTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'country' => 'United States',
                'country_code' => 'US',
                'latitude' => 39.76,
                'longitude' => - 98.5,
            ],
            [
                'country' => 'Russian Federation',
                'country_code' => 'RU',
                'latitude' => 60,
                'longitude' => 100,
            ],
            [
                'country' => 'Republic of France',
                'country_code' => 'FR',
                'latitude' => 46,
                'longitude' => 2,
            ]
        ];

        DB::table('country_geo_data')->insert($data);
    }
}
