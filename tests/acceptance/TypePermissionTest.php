<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Type;

class TypePermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/type">', true);
        
        $this->visit('/type')
            ->see('<i class="material-icons">filter_list</i>', true)
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/type')->see('<a href="'.$this->baseUrl.'/type/create', true);
        
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
    
    public function testAccessDeniedCompany()
    {
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);

        $this->visit('/type/1/edit');
        $this->see('accessdenied');
        
        $this->visit('/type/destroy/1');
        $this->see('accessdenied');
    }
}
