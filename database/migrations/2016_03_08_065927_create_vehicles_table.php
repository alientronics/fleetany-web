<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVehiclesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vehicles', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->index('fk_vehicles_companies1_idx');
			$table->integer('model_vehicle_id')->index('fk_vehicles_models1_idx');
			$table->string('number')->nullable();
			$table->integer('initial_miliage')->nullable();
			$table->integer('actual_miliage')->nullable();
			$table->string('geofence')->nullable();
			$table->decimal('cost', 15, 2);
			$table->text('description', 65535)->nullable();
			$table->text('fleet')->nullable();
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
		Schema::drop('vehicles');
	}

}
