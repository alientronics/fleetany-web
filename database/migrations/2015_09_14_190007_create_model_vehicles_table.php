<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('type_vehicle_id')->unsigned()->nullable()->index();;
            $table->integer('year');
            $table->integer('number_of_wheels');
            
            $table->foreign('type_vehicle_id')->references('id')->on('type_vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('model_vehicles');
    }
}
