<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTripsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('trips', function(Blueprint $table)
		{
			$table->foreign('company_id', 'fk_trips_companies1')->references('id')->on('companies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('driver_id', 'fk_trips_contacts1')->references('id')->on('contacts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('vehicle_id', 'fk_trips_vehicles1')->references('id')->on('vehicles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('vendor_id', 'fk_trips_contacts2')->references('id')->on('contacts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('trip_type_id', 'fk_trips_types1')->references('id')->on('types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('trips', function(Blueprint $table)
		{
			$table->dropForeign('fk_trips_companies1');
			$table->dropForeign('fk_trips_contacts1');
			$table->dropForeign('fk_trips_vehicles1');
			$table->dropForeign('fk_trips_contacts2');
			$table->dropForeign('fk_trips_types1');
		});
	}

}
