<?php

use Illuminate\Database\Seeder;
use App\Entities\Gps;

class GpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gps')->delete();
        Gps::forceCreate(
                [  'company_id' => 1,
                        'vehicle_id' => 1,
                        'driver_id' => 3,
                        'latitude' => '80',
                        'longitude' => '10']
            );
    }
}
