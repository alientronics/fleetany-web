<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class GpsModelTest extends UnitTestCase
{

    public function testHasCompany()
    {
    
        $company = factory(\App\Entities\Company::class)->create();
        $gps = factory(\App\Entities\Gps::class)->create([
            'company_id' => $company->id,
        ]);
    
        $this->assertEquals($gps->company->name, $company->name);
    }
    
    public function testHasContact()
    {
    
        $vehicle = factory(\App\Entities\Vehicle::class)->create();
        $gps = factory(\App\Entities\Gps::class)->create([
            'vehicle_id' => $vehicle->id,
        ]);
    
        $this->assertEquals($gps->vehicle->number, $vehicle->number);
    }
}
