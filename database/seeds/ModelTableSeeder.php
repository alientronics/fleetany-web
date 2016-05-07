<?php

use Illuminate\Database\Seeder;
use App\Entities\Model;

class ModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('models')->delete();
        Model::forceCreate(
                [  'model_type_id' => 2,
                        'vendor_id' => 2,
                        'name' => 'Generic Car',
                        'company_id' => 1]
            );
        Model::forceCreate(
                [  'model_type_id' => 10,
                        'vendor_id' => 2,
                        'name' => 'Generic Tire',
                        'company_id' => 1]
            );
        Model::forceCreate(
                [  'model_type_id' => 11,
                        'vendor_id' => 2,
                        'name' => 'Generic Sensor',
                        'company_id' => 1]
            );
    }
}
