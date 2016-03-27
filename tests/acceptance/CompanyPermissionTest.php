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
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/company">', true);
        
        $this->visit('/company')
            ->see('<i class="material-icons">filter_list</i>', true)
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/company')->see('<a href="'.$this->baseUrl.'/company/create', true);
        
        $this->visit('/company/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateExecutive()
    {
        $this->visit('/company')
            ->see('Editar', true)
        ;
        
        $this->visit('/company/'.Company::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->visit('/company')
            ->see('Excluir', true)
        ;
    }
}
