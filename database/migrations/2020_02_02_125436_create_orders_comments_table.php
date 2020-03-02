<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id')->default(0);
            $table->bigInteger('order_id')->unsigned();
            $table->text('order_comment')->nullable();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->timestamps();
            $table->softDeletes();
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_comments');
    }
}
