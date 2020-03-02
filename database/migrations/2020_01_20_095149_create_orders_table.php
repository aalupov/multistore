<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->default(0);
            $table->string('order_number')->unique;
            $table->decimal('shipping_amount', 8, 2)->default(0);
            $table->decimal('payment_fee', 8, 2)->default(0);
            $table->decimal('total_amount', 8, 2)->default(0);
            $table->integer('order_status_id');
            $table->string('ip_address')->nullable;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
