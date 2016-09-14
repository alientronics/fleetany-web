<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('services', function(Blueprint $table)
		{
			$table->foreign('company_id', 'fk_services_companies1')->references('id')->on('companies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('services', function(Blueprint $table)
		{
			$table->dropForeign('fk_services_companies1');
		});
	}

}
