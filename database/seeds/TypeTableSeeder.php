<?php

use Illuminate\Database\Seeder;
use App\Entities\Type;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->delete();
        Type::create(
                array(  'name' => 'vehicle',
                        'company_id' => 1)
            );
       
        
    }
}
