<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('contact_id')->nullable()->index('fk_companies_contacts1_idx');
			$table->string('name');
			$table->string('measure_units')->nullable();
			$table->string('api_token');
			$table->decimal('limit_temperature');
			$table->decimal('ideal_pressure');
			$table->decimal('delta_pressure');
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
		Schema::drop('companies');
	}

}
