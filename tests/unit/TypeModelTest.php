<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class TypeModelTest extends UnitTestCase
{

    public function testHasCompany()
    {
    
        $company = factory(\App\Entities\Company::class)->create();
        $type = factory(\App\Entities\Type::class)->create([
            'company_id' => $company->id,
        ]);
    
        $this->assertEquals($type->company->name, $company->name);
    }

    public function testHasContacts()
    {

        $type = factory(\App\Entities\Type::class)->create();

        $contact1 = factory(\App\Entities\Contact::class)->create([
                'contact_type_id' => $type->id,
            ]);

        $contact2 = factory(\App\Entities\Contact::class)->create([
                'contact_type_id' => $type->id,
            ]);

        $this->assertEquals(count($type->contacts), 2);
        $this->assertTrue($type->contacts->contains($contact1));
        $this->assertTrue($type->contacts->contains($contact2));
    }

    public function testHasEntries()
    {
    
        $type = factory(\App\Entities\Type::class)->create();
    
        $entry1 = factory(\App\Entities\Entry::class)->create([
            'entry_type_id' => $type->id,
        ]);
    
        $entry2 = factory(\App\Entities\Entry::class)->create([
            'entry_type_id' => $type->id,
        ]);
    
        $this->assertEquals(count($type->entries), 2);
        $this->assertTrue($type->entries->contains($entry1));
        $this->assertTrue($type->entries->contains($entry2));
    }
    
    public function testHasModels()
    {
    
        $type = factory(\App\Entities\Type::class)->create();
    
        $model1 = factory(\App\Entities\Model::class)->create([
            'model_type_id' => $type->id,
        ]);
    
        $model2 = factory(\App\Entities\Model::class)->create([
            'model_type_id' => $type->id,
        ]);
    
        $this->assertEquals(count($type->models), 2);
        $this->assertTrue($type->models->contains($model1));
        $this->assertTrue($type->models->contains($model2));
    }

    public function testHasTrips()
    {

        $type = factory(\App\Entities\Type::class)->create();

        $trip1 = factory(\App\Entities\Trip::class)->create([
                'trip_type_id' => $type->id,
            ]);

        $trip2 = factory(\App\Entities\Trip::class)->create([
                'trip_type_id' => $type->id,
            ]);

        $this->assertEquals(count($type->trips), 2);
        $this->assertTrue($type->trips->contains($trip1));
        $this->assertTrue($type->trips->contains($trip2));
    }

    public function testHasFuelTypes()
    {

        $type = factory(\App\Entities\Type::class)->create();

        $trip1 = factory(\App\Entities\Trip::class)->create([
                'company_id' => $type->id,
            ]);

        $trip2 = factory(\App\Entities\Trip::class)->create([
                'company_id' => $type->id,
            ]);

        $this->assertEquals(count($type->fuelTypes), 2);
        $this->assertTrue($type->fuelTypes->contains($trip1));
        $this->assertTrue($type->fuelTypes->contains($trip2));
        
    }

    public function testHasParts()
    {

        $type = factory(\App\Entities\Type::class)->create();

        $part1 = factory(\App\Entities\Part::class)->create([
                'part_type_id' => $type->id,
            ]);

        $part2 = factory(\App\Entities\Part::class)->create([
                'part_type_id' => $type->id,
            ]);

        $this->assertEquals(count($type->parts), 2);
        $this->assertTrue($type->parts->contains($part1));
        $this->assertTrue($type->parts->contains($part2));
        
    }
}
