<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('store_title');
            $table->text('store_description')->nullable();
            $table->boolean('store_is_activated')->default(false);
            $table->string('store_email');
            $table->string('store_country');
            $table->string('store_zip');
            $table->string('store_state');
            $table->string('store_city');
            $table->string('store_phone');
            $table->string('store_address');
            $table->string('store_picture')->nullable();
            $table->decimal('store_lat', 10, 8);
            $table->decimal('store_lon', 11, 8);
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
        Schema::dropIfExists('stores');
    }
}
