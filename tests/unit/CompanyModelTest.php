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
}
