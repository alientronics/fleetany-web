<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class PartHistoryModelTest extends UnitTestCase
{

    public function testHasVehicle()
    {
    
        $vehicle = factory(\App\Entities\Vehicle::class)->create();
        $part = factory(\App\Entities\Part::class)->create();
        
        $partHistory = factory(\App\Entities\PartHistory::class)->create([
            'vehicle_id' => $vehicle->id,
            'part_id' => $part->id
        ]);
    
        $this->assertEquals($partHistory->vehicle->number, $vehicle->number);
    }
    
    public function testHasPart()
    {
    
        $part = factory(\App\Entities\Part::class)->create();
        $partHistory = factory(\App\Entities\PartHistory::class)->create([
            'part_id' => $part->id,
        ]);
    
        $this->assertEquals($partHistory->part->name, $part->name);
    }
}
