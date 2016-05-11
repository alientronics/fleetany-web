<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\User;
use Lang;

class UserPermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->get('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/user">', true);
        
        $this->get('/user')->assertResponseStatus(401);
    }
    
    public function testCreateExecutive()
    {
        $this->get('/user/create')->assertResponseStatus(401);
    }
    
    public function testUpdateExecutive()
    {
        $this->get('/user/'.User::all()->last()['id'].'/edit')
            ->assertResponseStatus(401)
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->get('/user/destroy/'.User::all()->last()['id'])
            ->assertResponseStatus(302)
        ;
    }
    
    public function testAccessDeniedCompany()
    {
        $idAccessDenied = User::all()->last()['id'];
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);
        
        $this->visit('/user/'.$idAccessDenied.'/edit');
        $this->see(Lang::get('general.accessdenied'));
        
        $this->visit('/user/destroy/'.$idAccessDenied);
        $this->see(Lang::get('general.accessdenied'));
    }
}
