<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('models', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->index('fk_models_companies1_idx');
			$table->integer('model_type_id')->index('fk_models_types1_idx');
			$table->integer('vendor_id')->nullable()->index('fk_models_contacts1_idx');
			$table->string('name');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('models');
	}

}
