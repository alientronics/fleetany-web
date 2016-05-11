<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Model;
use Lang;

class ModelPermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->get('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/model">', true);
        
        $this->get('/model')->assertResponseStatus(401);
    }
    
    public function testCreateExecutive()
    {
        $this->get('/model/create')->assertResponseStatus(401);
    }
    
    public function testUpdateExecutive()
    {
        $this->get('/model/'.Model::all()->last()['id'].'/edit')
            ->assertResponseStatus(401)
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->get('/model/destroy/'.Model::all()->last()['id'])
            ->assertResponseStatus(302)
        ;
    }
    
    public function testAccessDeniedCompany()
    {
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);

        $this->visit('/model/1/edit');
        $this->see(Lang::get('general.accessdenied'));
        
        $model = Model::find(1);
        $model->vehicles()->delete();
        
        $this->visit('/model/destroy/1');
        $this->see(Lang::get('general.accessdenied'));
    }
}
