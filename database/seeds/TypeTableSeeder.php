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
                array(  'entity_key' => 'entry',
                        'name' => 'Entry',
                        'company_id' => 1)
            );
        Type::create(
                array(  'entity_key' => 'vehicle',
                        'name' => 'Vehicle',
                        'company_id' => 1)
            );
        Type::create(
                array(  'entity_key' => 'contact',
                        'name' => 'Contact',
                        'company_id' => 1)
            );
        Type::create(
                array(  'entity_key' => 'trip',
                        'name' => 'Trip',
                        'company_id' => 1)
            );
    }
}
