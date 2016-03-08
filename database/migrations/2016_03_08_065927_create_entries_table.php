<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEntriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entries', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->index('fk_entries_companies1_idx');
			$table->integer('entry_type_id')->index('fk_entries_types1_idx');
			$table->integer('vendor_id')->nullable()->index('fk_entries_contacts1_idx');
			$table->dateTime('datetime_ini');
			$table->dateTime('datetime_end')->nullable();
			$table->string('entry_number')->nullable();
			$table->decimal('cost');
			$table->text('description', 65535)->nullable();
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
		Schema::drop('entries');
	}

}
