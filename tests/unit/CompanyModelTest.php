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
}
