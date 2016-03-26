<?php

namespace Tests\Acceptance;

use Tests\TestCase;
use App\Entities\Type;

class TypeControllerTest extends TestCase
{
    public function testView()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/type">');
    
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
        $this->seeInDatabase('types', ['id' => $idDelete]);
        $this->visit('/type');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $this->click($idOption);
        $this->seeIsSoftDeletedInDatabase('types', ['id' => $idDelete]);
    }
}
