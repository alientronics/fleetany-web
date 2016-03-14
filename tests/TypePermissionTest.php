<?php

use App\Entities\Type;
class TypePermissionTest extends TestCase
{
    public function testViewAdmin()
    {
        $this->visit('/')->see('type">Tipos');
    
        $this->visit('/type')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testViewExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
    
        $this->visit('/')->see('type">Tipos', true);
    
        $this->visit('/type')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateAdmin()
    {
        $this->visit('/type')->see('Novo');
        
        $this->visit('/type/create');
    
        $this->type('Nome Tipo', 'name')
            ->press('Enviar')
            ->seePageIs('/type')
        ;
    
        $this->seeInDatabase('types', ['name' => 'Nome Tipo']);
    }
    
    public function testCreateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/type')->see('Novo', true);
    
        $this->visit('/type/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateAdmin()
    {
        $this->visit('/type/'.Type::all()->last()['id'].'/edit');
        
        $this->type('Nome Tipo Editado', 'name')
            ->press('Enviar')
            ->seePageIs('/type')
        ;
        
        $this->seeInDatabase('types', ['name' => 'Nome Tipo Editado']);
    }
    
    public function testUpdateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/type')
            ->see('Editar', true)
        ;
        
        $this->visit('/type/'.Type::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteAdmin()
    {
        $this->seeInDatabase('types', ['id' => 1]);
        $this->visit('/type');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $crawler = $this->click($idOption);
        $this->notSeeInDatabase('types', ['id' => 1]);
    }
    
    public function testDeleteExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/type')
            ->see('Excluir', true)
        ;
    }
}
