<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTireSensorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tire_sensor', function(Blueprint $table)
		{
		    $table->integer('id', true);
		    $table->integer('part_id')->index('fk_tire_sensor_parts1_idx');
		    $table->decimal('temperature');
		    $table->decimal('pressure');
		    $table->decimal('latitude', 10, 7);
		    $table->decimal('longitude', 10, 7);
		    $table->string('number');
		    $table->timestamps();
		    $table->softDeletes();
		    $table->engine = 'InnoDB';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tire_sensor');
	}

}
