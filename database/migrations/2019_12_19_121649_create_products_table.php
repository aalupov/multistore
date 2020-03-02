<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_id')->unsigned();
            $table->string('product_title');
            $table->string('product_sku');
            $table->text('product_description')->nullable();
            $table->decimal('product_regular_price', 8, 2)->nullable()->default(null);
            $table->decimal('product_sale_price', 8, 2)->nullable()->default(null);
            $table->string('product_type');
            $table->bigInteger('product_quantity')->default(0);
            $table->string('product_picture')->nullable();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->timestamps();
            $table->softDeletes();
            $table->index('store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
