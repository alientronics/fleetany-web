<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Model;

class ModelControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/model">');
    
        $this->visit('/model')
            ->see('<i class="material-icons">filter_list</i>')
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/model')->see('<a href="'.$this->baseUrl.'/model/create');
        
        $this->visit('/model/create');
    
        $this->type('Nome Modelo', 'name')
            ->press('Enviar')
            ->seePageIs('/model')
        ;
    
        $this->seeInDatabase('models', ['name' => 'Nome Modelo']);
    }
    
    public function testUpdate()
    {
        $this->visit('/model/'.Model::all()->last()['id'].'/edit');
        
        $this->type('Nome Modelo Editado', 'name')
            ->press('Enviar')
            ->seePageIs('/model')
        ;
        
        $this->seeInDatabase('models', ['name' => 'Nome Modelo Editado']);
    }
    
    public function testDelete()
    {
        $idDelete = Model::all()->last()['id'];
        $this->seeInDatabase('models', ['id' => $idDelete]);
        $this->visit('/model/destroy/'.$idDelete);
        $this->seeIsSoftDeletedInDatabase('models', ['id' => $idDelete]);
    }
    
    public function testErrors()
    {
        $this->visit('/model/create')
            ->press('Enviar')
            ->seePageIs('/model/create')
            ->see('de um valor para o campo nome.</span>')
        ;
    }
}
