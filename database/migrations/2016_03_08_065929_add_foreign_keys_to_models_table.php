<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToModelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('models', function(Blueprint $table)
		{
			$table->foreign('company_id', 'fk_models_companies1')->references('id')->on('companies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('model_type_id', 'fk_models_types1')->references('id')->on('types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('vendor_id', 'fk_models_contacts1')->references('id')->on('contacts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('models', function(Blueprint $table)
		{
			$table->dropForeign('fk_models_companies1');
			$table->dropForeign('fk_models_types1');
			$table->dropForeign('fk_models_contacts1');
		});
	}

}
