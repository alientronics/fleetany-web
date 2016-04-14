<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Contact;

class ContactControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/')->see('mdl-navigation__link" href="'.$this->baseUrl.'/contact">');
    
        $this->visit('/contact')
            ->see('<i class="material-icons">filter_list</i>')
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/contact')->see('<a href="'.$this->baseUrl.'/contact/create');
        
        $this->visit('/contact/create');
    
        $this->type('Nome Contato', 'name')
            ->type('Brasil', 'country')
            ->type('RS', 'state')
            ->type('Porto Alegre', 'city')
            ->type('Adress', 'address')
            ->type('(99) 9999-9999', 'phone')
            ->type('License', 'license_no')
            ->press('Enviar')
            ->seePageIs('/contact')
        ;
    
        $this->seeInDatabase(
            'contacts',
            [
                    'name' => 'Nome Contato',
                    'country' => 'Brasil',
                    'state' => 'RS',
                    'city' => 'Porto Alegre',
                    'address' => 'Adress',
                    'phone' => '(99) 9999-9999',
                    'license_no' => 'License',
            ]
        );
    }
    
    public function testUpdate()
    {
        $this->visit('/contact/'.Contact::all()->last()['id'].'/edit');
        
        $this->type('Nome Contato Editado', 'name')
            ->type('Brasil2', 'country')
            ->type('RS2', 'state')
            ->type('Porto Alegre2', 'city')
            ->type('Adress2', 'address')
            ->type('(99) 9999-9998', 'phone')
            ->type('License2', 'license_no')
            ->press('Enviar')
            ->seePageIs('/contact')
        ;
    
        $this->seeInDatabase(
            'contacts',
            [
                    'name' => 'Nome Contato Editado',
                    'country' => 'Brasil2',
                    'state' => 'RS2',
                    'city' => 'Porto Alegre2',
                    'address' => 'Adress2',
                    'phone' => '(99) 9999-9998',
                    'license_no' => 'License2',
            ]
        );
    }
    
    public function testDelete()
    {
        $idDelete = Contact::all()->last()['id'];
        
        $contact = Contact::find($idDelete);
        $contact->companies()->delete();
        $contact->entries()->delete();
        $contact->models()->delete();
        $contact->tripsDriver()->delete();
        $contact->tripsVendor()->delete();
        $contact->users()->delete();
        
        $this->seeInDatabase('contacts', ['id' => $idDelete]);
        $this->visit('/contact/destroy/'.$idDelete);
        $this->seeIsSoftDeletedInDatabase('contacts', ['id' => $idDelete]);
    }
    
    public function testErrors()
    {
        $this->visit('/contact/create')
            ->press('Enviar')
            ->seePageIs('/contact/create')
            ->see('de um valor para o campo nome.</span>')
        ;
    }
    
    public function testFilters()
    {
        $this->visit('/contact')
            ->type('Administrator', 'name')
            ->type('user', 'contact_type')
            ->type('City', 'city')
            ->press('Buscar')
            ->see('Administrator</div>')
            ->see('user</div>')
            ->see('City</div>')
        ;
    }
    
    public function testSort()
    {
        $this->visit('/contact?id=&name=&contact-type=&city=&sort=id-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/contact?id=&name=&contact-type=&city=&sort=id-asc')
            ->see('mode_edit</i>');
        
        $this->visit('/contact?id=&name=&contact-type=&city=&sort=name-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/contact?id=&name=&contact-type=&city=&sort=name-asc')
            ->see('mode_edit</i>');
        
        $this->visit('/contact?id=&name=&contact-type=&city=&sort=contact-type-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/contact?id=&name=&contact-type=&city=&sort=contact-type-asc')
            ->see('mode_edit</i>');
        
        $this->visit('/contact?id=&name=&contact-type=&city=&sort=city-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/contact?id=&name=&contact-type=&city=&sort=city-asc')
            ->see('mode_edit</i>');
    }
}
