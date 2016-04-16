<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Type;

class TypePermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->get('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/type">', true);
        
        $this->get('/type')->assertResponseStatus(401);
    }
    
    public function testCreateExecutive()
    {
        $this->get('/type/create')->assertResponseStatus(401);
    }
    
    public function testUpdateExecutive()
    {
        $this->get('/type/'.Type::all()->last()['id'].'/edit')
            ->assertResponseStatus(401)
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->get('/type/destroy/'.Type::all()->last()['id'])
            ->assertResponseStatus(302)
        ;
    }
    
    public function testAccessDeniedCompany()
    {
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);

        $this->visit('/type/1/edit');
        $this->see('Access denied');
        
        $type = Type::find(1);
        $type->contacts()->delete();
        $type->entries()->delete();
        $type->models()->delete();
        $type->trips()->delete();
        
        $this->visit('/type/destroy/1');
        $this->see('Access denied');
    }
}
