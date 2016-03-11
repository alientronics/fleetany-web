<?php

use Illuminate\Database\Seeder;
use App\Entities\Trip;

class TripTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trips')->delete();
        Trip::create(
                array(  'driver_id' => 1,
                        'vehicle_id' => 1,
                        'vendor_id' => 1,
                        'trip_type_id' => 1,
                        'pickup_date' => '2016-01-01',
                        'deliver_date' => '2016-01-01',
                        'pickup_place' => 1,
                        'deliver_place' => 1,
                        'begin_mileage' => 321,
                        'end_mileage' => 321,
                        'total_mileage' => 321,
                        'fuel_cost' => 321,
                        'fuel_amount' => 321,
                        'description' => 'Descricao Trip',
                        'company_id' => 1)
            );
    }
}
