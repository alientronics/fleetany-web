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
                ['name' => 'Company',
                'delta_pressure' => 10,
                'ideal_pressure' => 100,
                'limit_temperature' => 80,
                ]
            );
       
        
    }
}
