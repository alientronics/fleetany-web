<?php

use App\Entities\Company;

class CompanyControllerTest extends TestCase
{
    public function testView()
    {
        $this->visit('/')->see('company">Empresa');
    
        $this->visit('/company')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/company')->see('Novo');
        
        $this->visit('/company/create');
    
        $this->type('Nome Empresa', 'name')
            ->type('measure units', 'measure_units')
            ->type('api token', 'api_token')
            ->press('Enviar')
            ->seePageIs('/company')
        ;
    
        $this->seeInDatabase('companies', ['name' => 'Nome Empresa', 'measure_units' => 'measure units', 'api_token' => 'api token']);
    }
    
    public function testUpdate()
    {
        $this->visit('/company/'.Company::all()->last()['id'].'/edit');
        
        $this->type('Nome Empresa Editado', 'name')
            ->type('measure units editado', 'measure_units')
            ->type('api token editado', 'api_token')
            ->press('Enviar')
            ->seePageIs('/company')
        ;
        
        $this->seeInDatabase('companies', ['name' => 'Nome Empresa Editado', 'measure_units' => 'measure units editado', 'api_token' => 'api token editado']);
    
    }
    
    public function testDelete()
    {
        $this->seeInDatabase('companies', ['id' => 1]);
        $this->visit('/company');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $crawler = $this->click($idOption);
        $this->seeIsSoftDeletedInDatabase('companies', ['id' => 1]);
    }
}
