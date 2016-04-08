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
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/contact">', true);
        
        $this->visit('/contact')
            ->see('<i class="material-icons">filter_list</i>', true)
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/contact')->see('<a href="'.$this->baseUrl.'/contact/create', true);
    
        $this->visit('/contact/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateExecutive()
    {
        $this->visit('/contact')
            ->see('Editar', true)
        ;
        
        $this->visit('/contact/'.Contact::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->visit('/contact')
            ->see('Excluir', true)
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
