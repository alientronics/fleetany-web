<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEntriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('entries', function(Blueprint $table)
		{
			$table->foreign('company_id', 'fk_entries_companies1')->references('id')->on('companies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('entry_type_id', 'fk_entries_types1')->references('id')->on('types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('vendor_id', 'fk_entries_contacts1')->references('id')->on('contacts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('entries', function(Blueprint $table)
		{
			$table->dropForeign('fk_entries_companies1');
			$table->dropForeign('fk_entries_types1');
			$table->dropForeign('fk_entries_contacts1');
		});
	}

}
