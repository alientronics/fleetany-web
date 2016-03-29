<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class UserModelTest extends UnitTestCase
{

    public function testHasContact()
    {
    
        $contact = factory(\App\Entities\Contact::class)->create();
        $user = factory(\App\Entities\User::class)->create([
            'contact_id' => $contact->id,
        ]);
    
        $this->assertEquals($user->contact->name, $contact->name);
    }
    
    public function testHasCompany()
    {
    
        $company = factory(\App\Entities\Company::class)->create();
        $user = factory(\App\Entities\User::class)->create([
            'company_id' => $company->id,
        ]);
    
        $this->assertEquals($user->company->name, $company->name);
    }
}
