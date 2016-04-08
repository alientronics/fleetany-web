<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Type;

class TypeControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/')->see('mdl-navigation__link" href="'.$this->baseUrl.'/type">');
    
        $this->visit('/type')
            ->see('<i class="material-icons">filter_list</i>')
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/type')->see('<a href="'.$this->baseUrl.'/type/create');
        
        $this->visit('/type/create');
    
        $this->type('Nome Tipo', 'name')
            ->type('Entity Key', 'entity_key')
            ->press('Enviar')
            ->seePageIs('/type')
        ;
    
        $this->seeInDatabase('types', ['name' => 'Nome Tipo', 'entity_key' => 'Entity Key']);
    }

    public function testUpdate()
    {
        $this->visit('/type/'.Type::all()->last()['id'].'/edit');
        
        $this->type('Nome Tipo Editado', 'name')
            ->type('Entity Key Editado', 'entity_key')
            ->press('Enviar')
            ->seePageIs('/type')
        ;
        
        $this->seeInDatabase('types', ['name' => 'Nome Tipo Editado', 'entity_key' => 'Entity Key Editado']);
    }
    
    public function testDelete()
    {
        $idDelete = Type::all()->last()['id'];
        
        $type = Type::find($idDelete);
        $type->contacts()->delete();
        $type->entries()->delete();
        $type->models()->delete();
        $type->trips()->delete();
        
        $this->seeInDatabase('types', ['id' => $idDelete]);
        $this->visit('/type/destroy/'.$idDelete);
        $this->seeIsSoftDeletedInDatabase('types', ['id' => $idDelete]);
    }
    
    public function testErrors()
    {
        $this->visit('/type/create')
            ->press('Enviar')
            ->seePageIs('/type/create')
            ->see('de um valor para o campo nome.</span>')
        ;
    }
    
    public function testFilters()
    {
        $this->visit('/type')
            ->type('entry', 'entity_key')
            ->type('service', 'name')
            ->press('Buscar')
            ->see('entry</div>')
            ->see('service</div>')
        ;
    }
}
