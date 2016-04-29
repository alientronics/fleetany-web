<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablesProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
			$table->softDeletes();
			$table->engine = 'InnoDB';
        });
		
        Schema::table('role_user', function (Blueprint $table) {
			$table->softDeletes();
			$table->engine = 'InnoDB';
        });
		
        Schema::table('permissions', function (Blueprint $table) {
			$table->softDeletes();
			$table->engine = 'InnoDB';
        });
		
        Schema::table('permission_role', function (Blueprint $table) {
			$table->softDeletes();
			$table->engine = 'InnoDB';
        });
		
        Schema::table('permission_user', function (Blueprint $table) {
			$table->softDeletes();
			$table->engine = 'InnoDB';
        });
    }
}
