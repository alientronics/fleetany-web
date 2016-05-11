<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Part;
use Lang;

class PartPermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->get('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/part">', true);
        
        $this->get('/part')->assertResponseStatus(401);
    }
    
    public function testCreateExecutive()
    {
        $this->get('/part/create')->assertResponseStatus(401);
    }
    
    public function testUpdateExecutive()
    {
        $this->get('/part/'.Part::all()->last()['id'].'/edit')
            ->assertResponseStatus(401)
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->get('/part/destroy/'.Part::all()->last()['id'])
            ->assertResponseStatus(302)
        ;
    }
    
    public function testAccessDeniedCompany()
    {
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);

        $this->visit('/part/1/edit');
        $this->see(Lang::get('general.accessdenied'));
        
        $this->visit('/part/destroy/1');
        $this->see(Lang::get('general.accessdenied'));
    }
}
