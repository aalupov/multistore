<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryGeoDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_geo_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country');
            $table->string('country_code')->unique();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_geo_data');
    }
}
