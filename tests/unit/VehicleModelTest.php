<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class VehicleModelTest extends UnitTestCase
{

    public function testHasCompany()
    {
    
        $company = factory(\App\Entities\Company::class)->create();
        $vehicle = factory(\App\Entities\Vehicle::class)->create([
            'company_id' => $company->id,
        ]);
    
        $this->assertEquals($vehicle->company->name, $company->name);
    }
    
    public function testHasModel()
    {
    
        $model = factory(\App\Entities\Model::class)->create();
        $vehicle = factory(\App\Entities\Vehicle::class)->create([
            'model_vehicle_id' => $model->id,
        ]);
    
        $this->assertEquals($vehicle->model->name, $model->name);
    }

    public function testHasTrips()
    {

        $vehicle = factory(\App\Entities\Vehicle::class)->create();

        $trip1 = factory(\App\Entities\Trip::class)->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $trip2 = factory(\App\Entities\Trip::class)->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $this->assertEquals(count($vehicle->trips), 2);
        $this->assertTrue($vehicle->trips->contains($trip1));
        $this->assertTrue($vehicle->trips->contains($trip2));
    }

    public function testHasEntries()
    {

        $vehicle = factory(\App\Entities\Vehicle::class)->create();

        $entry1 = factory(\App\Entities\Entry::class)->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $entry2 = factory(\App\Entities\Entry::class)->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $this->assertEquals(count($vehicle->entries), 2);
        $this->assertTrue($vehicle->entries->contains($entry1));
        $this->assertTrue($vehicle->entries->contains($entry2));
    }

    public function testHasParts()
    {

        $vehicle = factory(\App\Entities\Vehicle::class)->create();

        $part1 = factory(\App\Entities\Part::class)->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $part2 = factory(\App\Entities\Part::class)->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $this->assertEquals(count($vehicle->parts), 2);
        $this->assertTrue($vehicle->parts->contains($part1));
        $this->assertTrue($vehicle->parts->contains($part2));
        
    }

    public function testHasPartsHistories()
    {

        $vehicle = factory(\App\Entities\Vehicle::class)->create();
        $part = factory(\App\Entities\Part::class)->create();

        $partsHistories1 = factory(\App\Entities\PartHistory::class)->create([
                'vehicle_id' => $vehicle->id,
                'part_id' => $part->id
            ]);

        $partsHistories2 = factory(\App\Entities\PartHistory::class)->create([
                'vehicle_id' => $vehicle->id,
                'part_id' => $part->id
            ]);

        $this->assertEquals(count($vehicle->partsHistories), 2);
        $this->assertTrue($vehicle->partsHistories->contains($partsHistories1));
        $this->assertTrue($vehicle->partsHistories->contains($partsHistories2));
        
    }
}
