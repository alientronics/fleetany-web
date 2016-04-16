<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Contact;
use App\Entities\User;

class ContactPermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->get('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/contact">', true);
        
        $this->get('/contact')->assertResponseStatus(401);
    }
    
    public function testCreateExecutive()
    {
        $this->get('/contact/create')->assertResponseStatus(401);
    }
    
    public function testUpdateExecutive()
    {
        $this->get('/contact/'.Contact::all()->last()['id'].'/edit')
            ->assertResponseStatus(401)
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->get('/contact/destroy/'.Contact::all()->last()['id'])
            ->assertResponseStatus(302)
        ;
    }
    
    public function testAccessDeniedCompany()
    {
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);

        $this->visit('/contact/1/edit');
        $this->see('Access denied');
        
        $contact = Contact::find(1);
        $contact->companies()->delete();
        $contact->entries()->delete();
        $contact->models()->delete();
        $contact->tripsDriver()->delete();
        $contact->tripsVendor()->delete();
        $contact->users()->delete();
        
        $this->visit('/contact/destroy/1');
        $this->see('Access denied');
    }
}
