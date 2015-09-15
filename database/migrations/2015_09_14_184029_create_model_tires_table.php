<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelTiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_tires', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('pressure_ideal');
            $table->integer('pressure_max');
            $table->integer('pressure_min');
            $table->integer('mileage');
            $table->decimal('temp_ideal');
            $table->decimal('temp_max');
            $table->decimal('temp_min');
            $table->decimal('start_diameter');
            $table->decimal('start_depth');
            $table->integer('type_land');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('model_tires');
    }
}
