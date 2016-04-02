<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Entry;

class EntryPermissionTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/entry">', true);
        
        $this->visit('/entry')
            ->see('<i class="material-icons">filter_list</i>', true)
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/entry')->see('<a href="'.$this->baseUrl.'/entry/create', true);
        
        $this->visit('/entry/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateExecutive()
    {
        $this->visit('/entry')
            ->see('Editar', true)
        ;
        
        $this->visit('/entry/'.Entry::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteExecutive()
    {
        $this->visit('/entry')
            ->see('Excluir', true)
        ;
    }
    
    public function testAccessDeniedCompany()
    {
        $user = factory(\App\Entities\User::class)->create();
        $user->setUp();
        $this->actingAs($user);

        $this->visit('/entry/1/edit');
        $this->see('accessdenied');
        
        $this->visit('/entry/destroy/1');
        $this->see('accessdenied');
    }
}
