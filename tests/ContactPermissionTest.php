<?php

use App\Entities\Contact;
class ContactPermissionTest extends TestCase
{
    public function testViewAdmin()
    {
        $this->visit('/')->see('contact">Contatos');
    
        $this->visit('/contact')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testViewExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
    
        $this->visit('/')->see('contact">Contatos', true);
    
        $this->visit('/contact')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateAdmin()
    {
        $this->visit('/contact')->see('Novo');
        
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
    
        $this->seeInDatabase('contacts', 
                [
                    'name' => 'Nome Contato',
                    'country' => 'Brasil',
                    'state' => 'RS',
                    'city' => 'Porto Alegre',
                    'address' => 'Adress',
                    'phone' => '(99) 9999-9999',
                    'license_no' => 'License',
                ]);
    }
    
    public function testCreateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/contact')->see('Novo', true);
    
        $this->visit('/contact/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateAdmin()
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
    
        $this->seeInDatabase('contacts', 
                [
                    'name' => 'Nome Contato Editado',
                    'country' => 'Brasil2',
                    'state' => 'RS2',
                    'city' => 'Porto Alegre2',
                    'address' => 'Adress2',
                    'phone' => '(99) 9999-9998',
                    'license_no' => 'License2',
                ]);
    }
    
    public function testUpdateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/contact')
            ->see('Editar', true)
        ;
        
        $this->visit('/contact/'.Contact::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteAdmin()
    {
        $this->seeInDatabase('contacts', ['id' => 1]);
        $this->visit('/contact');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $crawler = $this->click($idOption);
        $this->notSeeInDatabase('contacts', ['id' => 1]);
    }
    
    public function testDeleteExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/contact')
            ->see('Excluir', true)
        ;
    }
}
