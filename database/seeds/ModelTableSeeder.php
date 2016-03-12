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
        Model::create(
                array(  'model_type_id' => 2,
                        'vendor_id' => 2,
                        'name' => 'Palio',
                        'company_id' => 1)
            );
    }
}
