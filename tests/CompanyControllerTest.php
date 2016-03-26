<?php

namespace Tests\Acceptance;

use Tests\TestCase;
use App\Entities\Company;

class CompanyControllerTest extends TestCase
{
    public function testView()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/company">');
    
        $this->visit('/company')
            ->see('<i class="material-icons">filter_list</i>')
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/company')->see('<a href="'.$this->baseUrl.'/company/create');
        
        $this->visit('/company/create');
    
        $this->type('Nome Empresa', 'name')
            ->type('measure units', 'measure_units')
            ->type('api token', 'api_token')
            ->press('Enviar')
            ->seePageIs('/company')
        ;
    
        $this->seeInDatabase(
            'companies',
            ['name' => 'Nome Empresa',
            'measure_units' => 'measure units',
            'api_token' => 'api token']
        );
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
        
        $this->seeInDatabase(
            'companies',
            ['name' => 'Nome Empresa Editado',
            'measure_units' => 'measure units editado',
            'api_token' => 'api token editado']
        );
    
    }
    
    public function testDelete()
    {
        $idDelete = Company::all()->last()['id']; 
        $this->seeInDatabase('companies', ['id' => $idDelete]);
        $this->visit('/company');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $this->click($idOption);
        $this->seeIsSoftDeletedInDatabase('companies', ['id' => $idDelete]);
    }
}
