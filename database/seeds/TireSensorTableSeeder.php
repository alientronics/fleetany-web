<?php

use Illuminate\Database\Seeder;
use App\Entities\TireSensor;

class TireSensorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tire_sensor')->delete();
        TireSensor::forceCreate(
                [  'part_id' => 2,
                        'number' => '123456']
            );
    }
}
