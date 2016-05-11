<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Entry;
use Lang;

class EntryPermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->get('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/entry">', true);
        
        $this->get('/entry')->assertResponseStatus(401);
    }
    
    public function testCreateExecutive()
    {
        $this->get('/entry/create')->assertResponseStatus(401);
    }
    
    public function testUpdateExecutive()
    {
        $this->get('/entry/'.Entry::all()->last()['id'].'/edit')
            ->assertResponseStatus(401)
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->get('/entry/destroy/'.Entry::all()->last()['id'])
            ->assertResponseStatus(302)
        ;
    }
    
    public function testAccessDeniedCompany()
    {
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);

        $this->visit('/entry/1/edit');
        $this->see(Lang::get('general.accessdenied'));
        
        $this->visit('/entry/destroy/1');
        $this->see(Lang::get('general.accessdenied'));
    }
}
