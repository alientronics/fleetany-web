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
                [  'driver_id' => 3,
                        'vehicle_id' => 1,
                        'vendor_id' => 2,
                        'trip_type_id' => 6,
                        'pickup_date' => '2016-01-01',
                        'deliver_date' => '2016-01-01',
                        'pickup_place' => '1200 First Av',
                        'deliver_place' => '345 63th St',
                        'begin_mileage' => 320,
                        'end_mileage' => 450,
                        'total_mileage' => 130,
                        'fuel_cost' => 15,
                        'fuel_amount' => 5,
                        'description' => 'Descricao Trip',
                        'company_id' => 1]
            );
    }
}
