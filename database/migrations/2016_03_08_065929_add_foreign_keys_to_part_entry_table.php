<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPartEntryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('part_entry', function(Blueprint $table)
		{
			$table->foreign('entry_id', 'fk_part_entry_entries1_idx')->references('id')->on('entries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('part_id', 'fk_part_entry_parts1_idx')->references('id')->on('parts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('part_entry', function(Blueprint $table)
		{
			$table->dropForeign('fk_part_entry_entries1_idx');
			$table->dropForeign('fk_part_entry_parts1_idx');
		});
	}

}
