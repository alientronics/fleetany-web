<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('part_history', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('vehicle_id')->nullable()->index('fk_part_history_vehicles1_idx');
			$table->integer('part_id')->index('fk_part_history_parts1_idx');
			$table->char('position', 10);
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
		Schema::drop('part_history');
	}

}
