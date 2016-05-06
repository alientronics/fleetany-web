<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTireSensorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tire_sensor', function(Blueprint $table)
		{
			$table->foreign('part_id', 'fk_tire_sensor_parts1_idx')->references('id')->on('parts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tire_sensor', function(Blueprint $table)
		{
			$table->dropForeign('fk_tire_sensor_parts1_idx');
		});
	}

}
