<?php

use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::table('users', function($table) {
	        $table->dropColumn('username');
	        $table->dropColumn('first_name');
	        $table->dropColumn('last_name');
	        $table->string('email')->unique()->change();
	        $table->integer('company_id')->nullable()->index('fk_users_companies_idx');
	        $table->integer('contact_id')->nullable()->index('fk_users_contacts1_idx');
	        $table->integer('pending_company_id')->nullable()->index('fk_users_companies1_idx');
	        $table->string('name')->nullable();
	        $table->string('language')->default('en');
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
	    Schema::table('users', function($table) {
	        $table->string('username');
	        $table->string('first_name', 30)->nullable();
	        $table->string('last_name', 30)->nullable();
	        $table->dropColumn('company_id');
	        $table->dropColumn('contact_id');
	        $table->dropColumn('pending_company_id');
	        $table->dropColumn('name');
	        $table->dropColumn('language');
	        $table->dropColumn('deleted_at');
	    });
	}

}
