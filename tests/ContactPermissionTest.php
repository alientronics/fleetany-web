<?php

namespace Tests\Acceptance;

use Tests\TestCase;
use App\Entities\Contact;

class ContactPermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('contact">Contatos', true);
    
        $this->visit('/contact')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/contact')->see('Novo', true);
    
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
}
