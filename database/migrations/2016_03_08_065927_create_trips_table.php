<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTripsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trips', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->index('fk_trips_companies1_idx');
			$table->integer('driver_id')->nullable()->index('fk_trips_contacts1_idx');
			$table->integer('vehicle_id')->index('fk_trips_vehicles1_idx');
			$table->integer('vendor_id')->nullable()->index('fk_trips_contacts2_idx');
			$table->integer('trip_type_id')->index('fk_trips_types1_idx');
			$table->dateTime('pickup_date');
			$table->dateTime('deliver_date')->nullable();
			$table->string('pickup_place')->nullable();
			$table->string('deliver_place')->nullable();
			$table->integer('begin_mileage')->nullable();
			$table->integer('end_mileage');
			$table->integer('total_mileage')->nullable();
			$table->decimal('fuel_cost');
			$table->decimal('fuel_amount');
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
		Schema::drop('trips');
	}

}
