<?php

use App\Entities\Type;

class TypePermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('type">Tipos', true);
    
        $this->visit('/type')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/type')->see('Novo', true);
    
        $this->visit('/type/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateExecutive()
    {
        $this->visit('/type')
            ->see('Editar', true)
        ;
        
        $this->visit('/type/'.Type::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->visit('/type')
            ->see('Excluir', true)
        ;
    }
}
