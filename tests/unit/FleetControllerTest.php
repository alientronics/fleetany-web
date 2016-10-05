<?php

namespace Tests\Unit;

use Tests\UnitTestCase;
use App\Entities\User;
use Illuminate\Support\Facades\Session;
use App\Entities\Gps;
use App\Entities\TireSensor;

class FleetControllerTest extends UnitTestCase
{

    public function setUp()
    {
        parent::setUp();
        Session::start();
        $this->be(User::find(1));
    }
    
    public function testUpdateGpsData()
    {
        $this->get('/vehicle/fleet/dashboard/1990-01-01/1')->seeJsonContains([
            "latitude" => "80.0000000",
            "longitude" => "10.0000000"]);
    
        $updateDatetime = new \DateTime(date("Y-m-d H:i:s"));
        $updateDatetime->modify("-1 second");
        $updateDatetime = $updateDatetime->format("Y-m-d H:i:s");
        
        Gps::forceCreate(
            [  'company_id' => 1,
                'vehicle_id' => 1,
                'driver_id' => 3,
                'latitude' => '50',
                'longitude' => '20']
        );
        
        $this->get('/vehicle/fleet/dashboard/' . $updateDatetime . '/1')->seeJsonContains([
            "latitude" => "50.0000000",
            "longitude" => "20.0000000"]);
    }
    
    public function testUpdateSensorData()
    {
        $this->get('/vehicle/fleet/dashboard/1990-01-01/1')->seeJsonContains([
            "temperature" => "80.00",
            "pressure" => "10.00"]);
    
        $updateDatetime = new \DateTime(date("Y-m-d H:i:s"));
        $updateDatetime->modify("-1 second");
        $updateDatetime = $updateDatetime->format("Y-m-d H:i:s");
        
        TireSensor::forceCreate(
            [  'part_id' => 2,
                        'number' => '123456',
                        'temperature' => '99',
                        'pressure' => '23']
        );
        
        $this->get('/vehicle/fleet/dashboard/' . $updateDatetime . '/1')->seeJsonContains([
            "temperature" => "99.00",
            "pressure" => "23.00"]);
    }
}
