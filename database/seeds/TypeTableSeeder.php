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
                        'name' => 'service',
                        'company_id' => 1)
            );
        Type::create(
                array(  'entity_key' => 'vehicle',
                        'name' => 'car',
                        'company_id' => 1)
            );
        Type::create(
                array(  'entity_key' => 'contact',
                        'name' => 'user',
                        'company_id' => 1)
            );
        Type::create(
                array(  'entity_key' => 'contact',
                        'name' => 'driver',
                        'company_id' => 1)
            );
        Type::create(
                array(  'entity_key' => 'contact',
                        'name' => 'vendor',
                        'company_id' => 1)
            );
        Type::create(
                array(  'entity_key' => 'trip',
                        'name' => 'delivery',
                        'company_id' => 1)
            );
    }
}
