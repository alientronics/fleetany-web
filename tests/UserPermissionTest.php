<?php

namespace Tests\Acceptance;

use Tests\TestCase;
use App\Entities\User;

class UserPermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/user">', true);
        
        $this->visit('/user')
            ->see('<i class="material-icons">filter_list</i>', true)
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/user')->see('<a href="'.$this->baseUrl.'/user/create', true);
        
        $this->visit('/user/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateExecutive()
    {
        $this->visit('/user')
            ->see('Editar', true)
        ;
        
        $this->visit('/user/'.User::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->visit('/user')
            ->see('Excluir', true)
        ;
    }
}
