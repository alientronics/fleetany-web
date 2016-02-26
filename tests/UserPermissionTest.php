<?php

use App\User;
use App\Entities\ModelMonitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserPermissionTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testViewAdmin()
    {
        $this->visit('/')->see('Usuários');
    
        $this->visit('/user')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testViewExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
    
        $this->visit('/')->see('Usuários', true);
    
        $this->visit('/user')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateAdmin()
    {
        $this->visit('/user')->see('Novo');
        
        $this->visit('/user/create')
            ->type('Nome Usuario Teste', 'name')
            ->type('1', 'version')
            ->press('Enviar')
            ->seePageIs('/user')
        ;
        
        $this->seeInDatabase('users', ['name' => 'Nome Usuarios Teste', 'version' => '1']);
    }
    
    public function testCreateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/user')->see('Novo', true);
    
        $this->visit('/user/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateAdmin()
    {
        $modelMonitor = factory(User::class)->create([
            'name' => 'Nome Usuario Teste',
            'version' => 2,
        ]);
        
        $this->visit('/user/'.User::all()->last()['id'].'/edit')
            ->type('Nome Usuario Editado', 'name')
            ->type(2, 'version')
            ->press('Enviar')
        ;
        
        $this->seeInDatabase('users', ['name' => 'Nome Usuario Editado', 'version' => '2']);
    }
    
    public function testUpdateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $modelMonitor = factory(User::class)->create([
            'name' => 'Nome Usuario Teste',
            'version' => 2,
        ]);
        
        $this->visit('/user')
            ->see('Editar', true)
        ;
        
        $this->visit('/user/'.User::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteAdmin()
    {
        $modelMonitor = factory(User::class)->create([
            'name' => 'Nome Usuario Teste',
            'version' => 2,
        ]);
        
        $this->visit('/user')
            ->press('Excluir');
    
        $this->notSeeInDatabase('users', ['name' => 'Nome Usuario Editado', 'version' => '2']);
    }
    
    public function testDeleteExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $modelMonitor = factory(User::class)->create([
            'name' => 'Nome Usuario Teste',
            'version' => 2,
        ]);
        
        $this->visit('/user')
            ->see('Excluir', true)
        ;
    }
}
