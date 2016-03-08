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
        User::create(
                array(  'name' => 'Administrator',
                        'email' => 'admin@alientronics.com.br',
                        'password' => Hash::make('admin'),
                        'language' => 'pt-br',
                        'contact_id' => 1)
            );
       
        
    }
}
