<?php

use Illuminate\Database\Seeder;
use App\Entities\Vehicle;

class VehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicles')->delete();
        Vehicle::forceCreate(
                [  'model_vehicle_id' => 1,
                        'number' => 'IOP-1234',
                        'initial_miliage' => 1,
                        'actual_miliage' => 1,
                        'cost' => 50000,
                        'description' => 'Descricao Veiculo',
                        'company_id' => 1]
            );
    }
}
