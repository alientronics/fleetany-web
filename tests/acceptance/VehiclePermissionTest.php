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
        $this->get('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/vehicle">', true);
        
        $this->get('/vehicle')->assertResponseStatus(401);
    }
    
    public function testCreateExecutive()
    {
        $this->get('/vehicle/create')->assertResponseStatus(401);
    }
    
    public function testUpdateExecutive()
    {
        $this->get('/vehicle/'.Vehicle::all()->last()['id'].'/edit')
            ->assertResponseStatus(401)
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->get('/vehicle/destroy/'.Vehicle::all()->last()['id'])
            ->assertResponseStatus(302)
        ;
    }
    
    public function testAccessDeniedCompany()
    {
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);

        $this->visit('/vehicle/1/edit');
        $this->see('Access denied');

        $vehicle = Vehicle::find(1);
        $vehicle->entries()->delete();
        $vehicle->trips()->delete();
        
        $this->visit('/vehicle/destroy/1');
        $this->see('Access denied');
    }
}
