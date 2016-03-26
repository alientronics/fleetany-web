<?php

namespace Tests\Acceptance;

use Tests\TestCase;
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
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/trip">', true);
        
        $this->visit('/trip')
            ->see('<i class="material-icons">filter_list</i>', true)
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/trip')->see('<a href="'.$this->baseUrl.'/trip/create', true);
        
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
