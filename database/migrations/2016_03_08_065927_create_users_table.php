<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->nullable()->index('fk_users_companies_idx');
			$table->integer('contact_id')->index('fk_users_contacts1_idx');
			$table->integer('pending_company_id')->nullable()->index('fk_users_companies1_idx');
			$table->string('name')->nullable();
			$table->string('email');
			$table->string('password');
			$table->string('remember_token')->nullable();
			$table->string('language')->default('en');
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
		Schema::drop('users');
	}

}
