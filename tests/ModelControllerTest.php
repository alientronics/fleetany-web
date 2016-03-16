<?php

namespace Tests\Acceptance;

use Tests\TestCase;
use App\Entities\Model;

class ModelControllerTest extends TestCase
{
    public function testView()
    {
        $this->visit('/')->see('model">Modelos');
    
        $this->visit('/model')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/model')->see('Novo');
        
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
        $this->seeInDatabase('models', ['id' => 1]);
        $this->visit('/model');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $this->click($idOption);
        $this->seeIsSoftDeletedInDatabase('models', ['id' => 1]);
    }
}
