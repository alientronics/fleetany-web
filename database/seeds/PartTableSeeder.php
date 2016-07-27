<?php

use Illuminate\Database\Seeder;
use App\Entities\Part;

class PartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parts')->delete();
        Part::forceCreate(
                [  'vehicle_id' => 1,
                        'vendor_id' => 2,
                        'part_type_id' => 10,
                        'part_model_id' => 2,
                        'cost' => 200,
                        'name' => 'Part Name',
                        'number' => '123456',
                        'miliage' => 250,
                        'position' => 2,
                        'lifecycle' => 500,
                        'company_id' => 1]
            );
        Part::forceCreate(
                [  'vehicle_id' => 1,
                        'vendor_id' => 2,
                        'part_type_id' => 11,
                        'part_id' => 1,
                        'part_model_id' => 2,
                        'cost' => 200,
                        'name' => 'Part Sensor',
                        'number' => '123456',
                        'miliage' => 250,
                        'position' => 2,
                        'lifecycle' => 500,
                        'company_id' => 1]
            );
        Part::forceCreate(
                [  'vehicle_id' => 1,
                        'vendor_id' => 2,
                        'part_type_id' => 10,
                        'part_model_id' => 2,
                        'cost' => 200,
                        'name' => 'Part Name',
                        'number' => '123456',
                        'miliage' => 250,
                        'position' => 3,
                        'lifecycle' => 500,
                        'company_id' => 1]
            );
        Part::forceCreate(
                [  'vehicle_id' => 1,
                        'vendor_id' => 2,
                        'part_type_id' => 11,
                        'part_id' => 3,
                        'part_model_id' => 2,
                        'cost' => 200,
                        'name' => 'Part Sensor',
                        'number' => '123456',
                        'miliage' => 250,
                        'position' => 3,
                        'lifecycle' => 500,
                        'company_id' => 1]
            );
    }
}
