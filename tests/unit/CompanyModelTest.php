<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class CompanyModelTest extends UnitTestCase
{

    public function testHasContact()
    {

        $contact = factory(\App\Entities\Contact::class)->create();
        $company = factory(\App\Entities\Company::class)->create([
                'contact_id' => $contact->id,
            ]);

        $this->assertEquals($company->contact->name, $contact->name);
    }

    public function testHasContacts()
    {

        $company = factory(\App\Entities\Company::class)->create();

        $contact1 = factory(\App\Entities\Contact::class)->create([
                'company_id' => $company->id,
            ]);

        $contact2 = factory(\App\Entities\Contact::class)->create([
                'company_id' => $company->id,
            ]);

        $this->assertEquals(count($company->contacts), 2);
        $this->assertTrue($company->contacts->contains($contact1));
        $this->assertTrue($company->contacts->contains($contact2));
    }

    public function testHasEntries()
    {

        $company = factory(\App\Entities\Company::class)->create();

        $entry1 = factory(\App\Entities\Entry::class)->create([
                'company_id' => $company->id,
            ]);

        $entry2 = factory(\App\Entities\Entry::class)->create([
                'company_id' => $company->id,
            ]);

        $this->assertEquals(count($company->entries), 2);
        $this->assertTrue($company->entries->contains($entry1));
        $this->assertTrue($company->entries->contains($entry2));
    }

    public function testHasModels()
    {

        $company = factory(\App\Entities\Company::class)->create();

        $model1 = factory(\App\Entities\Model::class)->create([
                'company_id' => $company->id,
            ]);

        $model2 = factory(\App\Entities\Model::class)->create([
                'company_id' => $company->id,
            ]);

        $this->assertEquals(count($company->models), 2);
        $this->assertTrue($company->models->contains($model1));
        $this->assertTrue($company->models->contains($model2));
    }

    public function testHasParts()
    {

        $company = factory(\App\Entities\Company::class)->create();

        $part1 = factory(\App\Entities\Part::class)->create([
                'company_id' => $company->id,
            ]);

        $part2 = factory(\App\Entities\Part::class)->create([
                'company_id' => $company->id,
            ]);

        $this->assertEquals(count($company->parts), 2);
        $this->assertTrue($company->parts->contains($part1));
        $this->assertTrue($company->parts->contains($part2));
        
    }

    public function testHasTrips()
    {

        $company = factory(\App\Entities\Company::class)->create();

        $trip1 = factory(\App\Entities\Trip::class)->create([
                'company_id' => $company->id,
            ]);

        $trip2 = factory(\App\Entities\Trip::class)->create([
                'company_id' => $company->id,
            ]);

        $this->assertEquals(count($company->trips), 2);
        $this->assertTrue($company->trips->contains($trip1));
        $this->assertTrue($company->trips->contains($trip2));
    }

    public function testHasTypes()
    {

        $company = factory(\App\Entities\Company::class)->create();

        $type1 = factory(\App\Entities\Type::class)->create([
                'company_id' => $company->id,
            ]);

        $type2 = factory(\App\Entities\Type::class)->create([
                'company_id' => $company->id,
            ]);

        $this->assertEquals(count($company->types), 2);
        $this->assertTrue($company->types->contains($type1));
        $this->assertTrue($company->types->contains($type2));
    }

    public function testHasUsersCompany()
    {

        $company = factory(\App\Entities\Company::class)->create();

        $user1 = factory(\App\Entities\User::class)->create([
                'company_id' => $company->id,
            ]);

        $user2 = factory(\App\Entities\User::class)->create([
                'company_id' => $company->id,
            ]);

        $this->assertEquals(count($company->usersCompany), 2);
        $this->assertTrue($company->usersCompany->contains($user1));
        $this->assertTrue($company->usersCompany->contains($user2));
    }

    public function testHasUsersPendingCompany()
    {

        $company = factory(\App\Entities\Company::class)->create();

        $user1 = factory(\App\Entities\User::class)->create([
                'pending_company_id' => $company->id,
            ]);

        $user2 = factory(\App\Entities\User::class)->create([
                'pending_company_id' => $company->id,
            ]);

        $this->assertEquals(count($company->usersPendingCompany), 2);
        $this->assertTrue($company->usersPendingCompany->contains($user1));
        $this->assertTrue($company->usersPendingCompany->contains($user2));
    }

    public function testHasVehicles()
    {

        $company = factory(\App\Entities\Company::class)->create();

        $vehicle1 = factory(\App\Entities\Vehicle::class)->create([
                'company_id' => $company->id,
            ]);

        $vehicle2 = factory(\App\Entities\Vehicle::class)->create([
                'company_id' => $company->id,
            ]);

        $this->assertEquals(count($company->vehicles), 2);
        $this->assertTrue($company->vehicles->contains($vehicle1));
        $this->assertTrue($company->vehicles->contains($vehicle2));
    }
}
