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
		    $table->integer('part_id')->nullable()->index('fk_tire_sensor_parts1_idx');
		    $table->decimal('temperature')->nullable();
		    $table->decimal('pressure')->nullable();
		    $table->decimal('battery')->nullable();
		    $table->decimal('latitude', 10, 7)->nullable();
		    $table->decimal('longitude', 10, 7)->nullable();
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
