<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Trip;

class TripPermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->get('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/trip">', true);
        
        $this->get('/trip')->assertResponseStatus(401);
    }
    
    public function testCreateExecutive()
    {
        $this->get('/trip/create')->assertResponseStatus(401);
    }
    
    public function testUpdateExecutive()
    {
        $this->get('/trip/'.Trip::all()->last()['id'].'/edit')
            ->assertResponseStatus(401)
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->get('/trip/destroy/'.Trip::all()->last()['id'])
            ->assertResponseStatus(302)
        ;
    }
    
    public function testAccessDeniedCompany()
    {
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);

        $this->visit('/trip/1/edit');
        $this->see('Access denied');
        
        $this->visit('/trip/destroy/1');
        $this->see('Access denied');
    }
}
