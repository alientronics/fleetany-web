<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGpsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gps', function(Blueprint $table)
		{
			$table->foreign('company_id', 'fk_gps_companies1_idx')->references('id')->on('companies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('vehicle_id', 'fk_gps_vehicles1_idx')->references('id')->on('vehicles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('gps', function(Blueprint $table)
		{
			$table->dropForeign('fk_gps_companies1_idx');
			$table->dropForeign('fk_gps_vehicles1_idx');
		});
	}

}
