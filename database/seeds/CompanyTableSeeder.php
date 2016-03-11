<?php

use Illuminate\Database\Seeder;
use App\Entities\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->delete();
        Company::create(
                array(  'name' => 'Company',
                        'api_token' => 1)
            );
       
        
    }
}
