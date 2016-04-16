<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Company;

class CompanyPermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->get('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/company">', true);
        
        $this->get('/company')->assertResponseStatus(401);
    }
    
    public function testCreateExecutive()
    {
        $this->get('/company/create')->assertResponseStatus(401);
    }
    
    public function testUpdateExecutive()
    {
        $this->get('/company/'.Company::all()->last()['id'].'/edit')
            ->assertResponseStatus(401)
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->get('/company/destroy/'.Company::all()->last()['id'])
            ->assertResponseStatus(302)
        ;
    }
}
