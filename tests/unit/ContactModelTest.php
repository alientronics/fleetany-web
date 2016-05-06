<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class ContactModelTest extends UnitTestCase
{

    public function testHasCompany()
    {
    
        $company = factory(\App\Entities\Company::class)->create();
        $contact = factory(\App\Entities\Contact::class)->create([
            'company_id' => $company->id,
        ]);
    
        $this->assertEquals($contact->company->name, $company->name);
    }
    
    public function testHasType()
    {

        $type = factory(\App\Entities\Type::class)->create();
        $contact = factory(\App\Entities\Contact::class)->create([
                'contact_type_id' => $type->id,
            ]);

        $this->assertEquals($contact->type->name, $type->name);
    }

    public function testHasCompanies()
    {

        $contact = factory(\App\Entities\Contact::class)->create();

        $company1 = factory(\App\Entities\Company::class)->create([
                'contact_id' => $contact->id,
            ]);

        $company2 = factory(\App\Entities\Company::class)->create([
                'contact_id' => $contact->id,
            ]);

        $this->assertEquals(count($contact->companies), 2);
        $this->assertTrue($contact->companies->contains($company1));
        $this->assertTrue($contact->companies->contains($company2));
    }

    public function testHasEntries()
    {

        $contact = factory(\App\Entities\Contact::class)->create();

        $entry1 = factory(\App\Entities\Entry::class)->create([
                'vendor_id' => $contact->id,
            ]);

        $entry2 = factory(\App\Entities\Entry::class)->create([
                'vendor_id' => $contact->id,
            ]);

        $this->assertEquals(count($contact->entries), 2);
        $this->assertTrue($contact->entries->contains($entry1));
        $this->assertTrue($contact->entries->contains($entry2));
    }

    public function testHasModels()
    {

        $contact = factory(\App\Entities\Contact::class)->create();

        $model1 = factory(\App\Entities\Model::class)->create([
                'vendor_id' => $contact->id,
            ]);

        $model2 = factory(\App\Entities\Model::class)->create([
                'vendor_id' => $contact->id,
            ]);

        $this->assertEquals(count($contact->models), 2);
        $this->assertTrue($contact->models->contains($model1));
        $this->assertTrue($contact->models->contains($model2));
    }

    public function testHasParts()
    {

        $contact = factory(\App\Entities\Contact::class)->create();

        $part1 = factory(\App\Entities\Part::class)->create([
                'company_id' => $contact->id,
            ]);

        $part2 = factory(\App\Entities\Part::class)->create([
                'company_id' => $contact->id,
            ]);

        $this->assertEquals(count($contact->parts), 2);
        $this->assertTrue($contact->parts->contains($part1));
        $this->assertTrue($contact->parts->contains($part2));
        
    }

    public function testHasTripsDriver()
    {

        $contact = factory(\App\Entities\Contact::class)->create();

        $tripDriver1 = factory(\App\Entities\Trip::class)->create([
                'driver_id' => $contact->id,
            ]);

        $tripDriver2 = factory(\App\Entities\Trip::class)->create([
                'driver_id' => $contact->id,
            ]);

        $this->assertEquals(count($contact->tripsDriver), 2);
        $this->assertTrue($contact->tripsDriver->contains($tripDriver1));
        $this->assertTrue($contact->tripsDriver->contains($tripDriver2));
    }

    public function testHasTripsVendor()
    {

        $contact = factory(\App\Entities\Contact::class)->create();

        $tripVendor1 = factory(\App\Entities\Trip::class)->create([
                'vendor_id' => $contact->id,
            ]);

        $tripVendor2 = factory(\App\Entities\Trip::class)->create([
                'vendor_id' => $contact->id,
            ]);

        $this->assertEquals(count($contact->tripsVendor), 2);
        $this->assertTrue($contact->tripsVendor->contains($tripVendor1));
        $this->assertTrue($contact->tripsVendor->contains($tripVendor2));
    }

    public function testHasUsers()
    {

        $contact = factory(\App\Entities\Contact::class)->create();

        $user1 = factory(\App\Entities\User::class)->create([
                'contact_id' => $contact->id,
            ]);

        $user2 = factory(\App\Entities\User::class)->create([
                'contact_id' => $contact->id,
            ]);

        $this->assertEquals(count($contact->users), 2);
        $this->assertTrue($contact->users->contains($user1));
        $this->assertTrue($contact->users->contains($user2));
    }
}
