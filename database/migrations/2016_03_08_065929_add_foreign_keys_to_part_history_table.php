<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPartHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('part_history', function(Blueprint $table)
		{
			$table->foreign('vehicle_id', 'fk_part_history_vehicles1_idx')->references('id')->on('vehicles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('part_id', 'fk_part_history_parts1_idx')->references('id')->on('parts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('part_history', function(Blueprint $table)
		{
			$table->dropForeign('fk_part_history_vehicles1_idx');
			$table->dropForeign('fk_part_history_parts1_idx');
		});
	}

}
