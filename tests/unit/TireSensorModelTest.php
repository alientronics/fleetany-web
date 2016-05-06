<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class TireSensorModelTest extends UnitTestCase
{

    public function testHasPart()
    {
    
        $part = factory(\App\Entities\Part::class)->create();
        $tireSensor = factory(\App\Entities\TireSensor::class)->create([
            'part_id' => $part->id,
        ]);
    
        $this->assertEquals($tireSensor->part->name, $part->name);
    }
}
