<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::statement('alter table users AUTO_INCREMENT = 1');
        User::create(
                array(  'name' => 'Administrator',
                        'email' => 'admin@alientronics.com.br',
                        'password' => Hash::make('admin'))
            );
       
        
    }
}
