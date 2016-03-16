<?php

namespace Tests\Acceptance;

use Tests\TestCase;
use App\Entities\Vehicle;

class VehiclePermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('vehicle">Ve', true);
    
        $this->visit('/vehicle')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/vehicle')->see('Novo', true);
    
        $this->visit('/vehicle/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateExecutive()
    {
        $this->visit('/vehicle')
            ->see('Editar', true)
        ;
        
        $this->visit('/vehicle/'.Vehicle::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->visit('/vehicle')
            ->see('Excluir', true)
        ;
    }
}
