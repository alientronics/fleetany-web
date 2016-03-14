<?php

use App\Entities\Model;
class ModelPermissionTest extends TestCase
{
    public function testViewAdmin()
    {
        $this->visit('/')->see('model">Modelos');
    
        $this->visit('/model')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testViewExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
    
        $this->visit('/')->see('model">Modelos', true);
    
        $this->visit('/model')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateAdmin()
    {
        $this->visit('/model')->see('Novo');
        
        $this->visit('/model/create');
    
        $this->type('Nome Modelo', 'name')
            ->press('Enviar')
            ->seePageIs('/model')
        ;
    
        $this->seeInDatabase('models', ['name' => 'Nome Modelo']);
    }
    
    public function testCreateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/model')->see('Novo', true);
    
        $this->visit('/model/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateAdmin()
    {
        $this->visit('/model/'.Model::all()->last()['id'].'/edit');
        
        $this->type('Nome Modelo Editado', 'name')
            ->press('Enviar')
            ->seePageIs('/model')
        ;
        
        $this->seeInDatabase('models', ['name' => 'Nome Modelo Editado']);
    }
    
    public function testUpdateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/model')
            ->see('Editar', true)
        ;
        
        $this->visit('/model/'.Model::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteAdmin()
    {
        $this->seeInDatabase('models', ['id' => 1]);
        $this->visit('/model');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $crawler = $this->click($idOption);
        $this->notSeeInDatabase('models', ['id' => 1]);
    }
    
    public function testDeleteExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/model')
            ->see('Excluir', true)
        ;
    }
}
