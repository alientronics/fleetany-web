<?php

use App\Entities\Company;

class CompanyPermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('company">Empresa', true);
    
        $this->visit('/company')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/company')->see('Novo', true);
    
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
