<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Company;

class CompanyControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
//         $this->visit('/')->see('mdl-navigation__link" href="'.$this->baseUrl.'/company">');
    
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
            ->press('Enviar')
            ->seePageIs('/company')
        ;
    
        $this->seeInDatabase(
            'companies',
            ['name' => 'Nome Empresa',
            'measure_units' => 'measure units']
        );
    }
    
    public function testUpdate()
    {
        $this->visit('/company/'.Company::all()->last()['id'].'/edit');
        
        $this->type('Nome Empresa Editado', 'name')
            ->type('measure units editado', 'measure_units')
            ->type('Brasil2', 'country')
            ->type('RS2', 'state')
            ->type('Porto Alegre2', 'city')
            ->type('Adress2', 'address')
            ->type('(99) 9999-9998', 'phone')
            ->press('Enviar')
            ->seePageIs('/company')
        ;
        
        $this->seeInDatabase(
            'companies',
            ['name' => 'Nome Empresa Editado',
            'measure_units' => 'measure units editado']
        );
        
        $this->seeInDatabase(
            'contacts',
            ['name' => 'Nome Empresa Editado',
            'country' => 'Brasil2',
            'state' => 'RS2',
            'city' => 'Porto Alegre2',
            'address' => 'Adress2',
            'phone' => '(99) 9999-9998']
        );
    }
    
    public function testDelete()
    {
        $idDelete = Company::all()->last()['id'];
        
        $company = Company::find($idDelete);
        $company->contacts()->delete();
        $company->entries()->delete();
        $company->models()->delete();
        $company->trips()->delete();
        $company->types()->delete();
        $company->usersCompany()->delete();
        $company->usersPendingCompany()->delete();
        $company->vehicles()->delete();
        
        $this->seeInDatabase('companies', ['id' => $idDelete]);
        $this->visit('/company/destroy/'.$idDelete);
        $this->seeIsSoftDeletedInDatabase('companies', ['id' => $idDelete]);
    }
    
    public function testErrors()
    {
        $this->visit('/company/create')
            ->press('Enviar')
            ->seePageIs('/company/create')
            ->see('de um valor para o campo nome.</span>')
        ;
    }
    
    public function testFilters()
    {
        $this->visit('/company')
            ->type('Company', 'name')
            ->type('City', 'city')
            ->type('Country', 'country')
            ->press('Buscar')
            ->see('Company</div>')
            ->see('City</div>')
            ->see('Country</div>')
        ;
    }
}
