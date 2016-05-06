<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class TripModelTest extends UnitTestCase
{

    public function testHasCompany()
    {
    
        $company = factory(\App\Entities\Company::class)->create();
        $trip = factory(\App\Entities\Trip::class)->create([
            'company_id' => $company->id,
        ]);
    
        $this->assertEquals($trip->company->name, $company->name);
    }
    
    public function testHasContactDriver()
    {
    
        $contactDriver = factory(\App\Entities\Contact::class)->create();
        $trip = factory(\App\Entities\Trip::class)->create([
            'driver_id' => $contactDriver->id,
        ]);
    
        $this->assertEquals($trip->contactDriver->name, $contactDriver->name);
    }
    
    public function testHasVehicle()
    {
    
        $vehicle = factory(\App\Entities\Vehicle::class)->create();
        $trip = factory(\App\Entities\Trip::class)->create([
            'vehicle_id' => $vehicle->id,
        ]);
    
        $this->assertEquals($trip->vehicle->model_vehicle_id, $vehicle->model_vehicle_id);
    }
    
    public function testHasContactVendor()
    {
    
        $contactVendor = factory(\App\Entities\Contact::class)->create();
        $trip = factory(\App\Entities\Trip::class)->create([
            'vendor_id' => $contactVendor->id,
        ]);
    
        $this->assertEquals($trip->contactVendor->name, $contactVendor->name);
    }
    
    public function testHasType()
    {
    
        $type = factory(\App\Entities\Type::class)->create();
        $trip = factory(\App\Entities\Trip::class)->create([
            'trip_type_id' => $type->id,
        ]);
    
        $this->assertEquals($trip->type->name, $type->name);
    }
    
    public function testHasFuelType()
    {
    
        $fuelType = factory(\App\Entities\Type::class)->create();
        $trip = factory(\App\Entities\Trip::class)->create([
            'fuel_type' => $fuelType->id,
        ]);
    
        $this->assertEquals($trip->fuelType->name, $fuelType->name);
    }
}
