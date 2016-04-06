<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Vehicle;

class VehiclePermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/vehicle">', true);
        
        $this->visit('/vehicle')
            ->see('<i class="material-icons">filter_list</i>', true)
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/vehicle')->see('<a href="'.$this->baseUrl.'/vehicle/create', true);
        
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
    
    public function testAccessDeniedCompany()
    {
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);

        $this->visit('/vehicle/1/edit');
        $this->see('Access denied');

        $this->visit('/vehicle/destroy/1');
        $this->see('Access denied');
    }
}
