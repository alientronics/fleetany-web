<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Contact;

class ContactControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/contact">');
    
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
            ->see('de um valor para o campo license no.</span>')
        ;
    }
    
    public function testFilters()
    {
        $this->visit('/contact')
            ->type('Administrator', 'name')
            ->type('user', 'contact_type')
            ->type('City', 'city')
            ->press('Buscar')
            ->see('<td class="mdl-data-table__cell--non-numeric"> 1 </td>')
        ;
    }
}
