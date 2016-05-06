<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('parts', function(Blueprint $table)
		{
			$table->foreign('company_id', 'fk_parts_companies1_idx')->references('id')->on('companies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('vehicle_id', 'fk_parts_vehicles1_idx')->references('id')->on('vehicles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('vendor_id', 'fk_parts_contacts1_idx')->references('id')->on('contacts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('part_type_id', 'fk_parts_types1_idx')->references('id')->on('types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('part_model_id', 'fk_parts_models1_idx')->references('id')->on('models')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('part_id', 'fk_parts_parts1_idx')->references('id')->on('parts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('parts', function(Blueprint $table)
		{
			$table->dropForeign('fk_parts_companies1_idx');
			$table->dropForeign('fk_parts_vehicles1_idx');
			$table->dropForeign('fk_parts_contacts1_idx');
			$table->dropForeign('fk_parts_types1_idx');
			$table->dropForeign('fk_parts_models1_idx');
			$table->dropForeign('fk_parts_parts1_idx');
		});
	}

}
