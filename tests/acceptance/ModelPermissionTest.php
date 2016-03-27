<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Model;

class ModelPermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/model">', true);
        
        $this->visit('/model')
            ->see('<i class="material-icons">filter_list</i>', true)
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/model')->see('<a href="'.$this->baseUrl.'/model/create', true);
        
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
