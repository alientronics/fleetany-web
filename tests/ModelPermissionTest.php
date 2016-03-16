<?php

namespace Tests\Acceptance;

use Tests\TestCase;
use App\Entities\Model;

class ModelPermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('model">Modelos', true);
    
        $this->visit('/model')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/model')->see('Novo', true);
    
        $this->visit('/model/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateExecutive()
    {
        $this->visit('/model')
            ->see('Editar', true)
        ;
        
        $this->visit('/model/'.Model::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->visit('/model')
            ->see('Excluir', true)
        ;
    }
}
