<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class PartsModelTest extends UnitTestCase
{

    public function testHasCompany()
    {
    
        $company = factory(\App\Entities\Company::class)->create();
        $part = factory(\App\Entities\Part::class)->create([
            'company_id' => $company->id,
        ]);
    
        $this->assertEquals($part->company->name, $company->name);
    }
    
    public function testHasVehicle()
    {
    
        $vehicle = factory(\App\Entities\Vehicle::class)->create();
        $part = factory(\App\Entities\Part::class)->create([
            'vehicle_id' => $vehicle->id,
        ]);
    
        $this->assertEquals($part->vehicle->number, $vehicle->number);
    }
    
    public function testHasVendor()
    {
    
        $vendor = factory(\App\Entities\Contact::class)->create();
        $part = factory(\App\Entities\Part::class)->create([
            'vendor_id' => $vendor->id,
        ]);
    
        $this->assertEquals($part->vendor->name, $vendor->name);
    }
    
    public function testHasPartType()
    {
    
        $partType = factory(\App\Entities\Type::class)->create();
        $part = factory(\App\Entities\Part::class)->create([
            'part_type_id' => $partType->id,
        ]);
    
        $this->assertEquals($part->partType->name, $partType->name);
    }
    
    public function testHasPartModel()
    {
    
        $partModel = factory(\App\Entities\Model::class)->create();
        $part = factory(\App\Entities\Part::class)->create([
            'part_model_id' => $partModel->id,
        ]);
    
        $this->assertEquals($part->partModel->name, $partModel->name);
    }
    
    public function testHasPart()
    {
    
        $partChild = factory(\App\Entities\Part::class)->create();
        $part = factory(\App\Entities\Part::class)->create([
            'part_id' => $partChild->id,
        ]);
    
        $this->assertEquals($part->part->name, $partChild->name);
    }

    public function testHasPartsHistories()
    {

        $part = factory(\App\Entities\Part::class)->create();

        $partHistory1 = factory(\App\Entities\PartHistory::class)->create([
                'part_id' => $part->id,
            ]);

        $partHistory2 = factory(\App\Entities\PartHistory::class)->create([
                'part_id' => $part->id,
            ]);

        $this->assertEquals(count($part->partsHistories), 2);
        $this->assertTrue($part->partsHistories->contains($partHistory1));
        $this->assertTrue($part->partsHistories->contains($partHistory2));
    }

    public function testHasTireSensors()
    {

        $part = factory(\App\Entities\Part::class)->create();

        $tireSensor1 = factory(\App\Entities\TireSensor::class)->create([
                'part_id' => $part->id,
            ]);

        $tireSensor2 = factory(\App\Entities\TireSensor::class)->create([
                'part_id' => $part->id,
            ]);

        $this->assertEquals(count($part->tireSensors), 2);
        $this->assertTrue($part->tireSensors->contains($tireSensor1));
        $this->assertTrue($part->tireSensors->contains($tireSensor2));
    }
}
