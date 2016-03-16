<?php

namespace Tests\Acceptance;

use Tests\TestCase;
use App\Entities\Entry;

class EntryPermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $user = $this->createExecutive();
        $this->actingAs($user);
    }
    
    public function testViewExecutive()
    {
        $this->visit('/')->see('entry">Entrada', true);
    
        $this->visit('/entry')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateExecutive()
    {
        $this->visit('/entry')->see('Novo', true);
    
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
}
