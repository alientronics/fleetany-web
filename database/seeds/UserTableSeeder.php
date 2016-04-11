<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use Illuminate\Support\Facades\Hash;

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
                        'company_id' => 1,
                        'contact_id' => 1)
            );
       
        
    }
}
