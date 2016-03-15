<?php

use App\Entities\Trip;

class TripPermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('trip">Viagens', true);
    
        $this->visit('/trip')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/trip')->see('Novo', true);
    
        $this->visit('/trip/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateExecutive()
    {
        $this->visit('/trip')
            ->see('Editar', true)
        ;
        
        $this->visit('/trip/'.Trip::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->visit('/trip')
            ->see('Excluir', true)
        ;
    }
}
