<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class EntryModelTest extends UnitTestCase
{

    public function testHasCompany()
    {
    
        $company = factory(\App\Entities\Company::class)->create();
        $entry = factory(\App\Entities\Entry::class)->create([
            'company_id' => $company->id,
        ]);
    
        $this->assertEquals($entry->company->name, $company->name);
    }
    
    public function testHasType()
    {
    
        $type = factory(\App\Entities\Type::class)->create();
        $entry = factory(\App\Entities\Entry::class)->create([
            'entry_type_id' => $type->id,
        ]);
    
        $this->assertEquals($entry->type->name, $type->name);
    }
    
    public function testHasContact()
    {
    
        $contact = factory(\App\Entities\Contact::class)->create();
        $entry = factory(\App\Entities\Entry::class)->create([
            'vendor_id' => $contact->id,
        ]);
    
        $this->assertEquals($entry->contact->name, $contact->name);
    }
    
    public function testHasVehicle()
    {
    
        $vehicle = factory(\App\Entities\Vehicle::class)->create();
        $entry = factory(\App\Entities\Entry::class)->create([
            'vehicle_id' => $vehicle->id,
        ]);
    
        $this->assertEquals($entry->vehicle->model_vehicle_id, $vehicle->model_vehicle_id);
    }

    public function testHasPartsEntries()
    {

        $entry = factory(\App\Entities\Entry::class)->create();
        $part = factory(\App\Entities\Part::class)->create();

        $partsEntries1 = factory(\App\Entities\PartEntry::class)->create([
                'entry_id' => $entry->id,
                'part_id' => $part->id
            ]);

        $partsEntries2 = factory(\App\Entities\PartEntry::class)->create([
                'entry_id' => $entry->id,
                'part_id' => $part->id
            ]);

        $this->assertEquals(count($entry->partsEntries), 2);
        $this->assertTrue($entry->partsEntries->contains($partsEntries1));
        $this->assertTrue($entry->partsEntries->contains($partsEntries2));
        
    }
}
