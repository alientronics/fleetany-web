<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->index('fk_parts_companies1_idx');
			$table->integer('vehicle_id')->nullable()->index('fk_parts_vehicles1_idx');
			$table->integer('vendor_id')->nullable()->index('fk_parts_contacts1_idx');
			$table->integer('part_type_id')->index('fk_parts_types1_idx');
			$table->integer('part_model_id')->index('fk_parts_models1_idx');
			$table->integer('part_id')->nullable()->index('fk_parts_parts1_idx');
			$table->decimal('cost')->nullable();
			$table->string('name')->nullable();			
			$table->string('number');
			$table->integer('miliage')->nullable();
			$table->integer('position')->nullable();
			$table->integer('lifecycle')->nullable();
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
		Schema::drop('parts');
	}

}
