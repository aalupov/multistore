<?php

use Illuminate\Database\Seeder;

class OrdersStatusesTableSeeder extends Seeder
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
                'order_status' => 'pending',
            ],
            [
                'order_status' => 'processing',
            ],
            [
                'order_status' => 'completed',
            ],
            [
                'order_status' => 'shipped',
            ],
            [
                'order_status' => 'refunded',
            ],
        ];
        
        DB::table('orders_statuses')->insert($data);
    }
}
