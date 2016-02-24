<?php

use App\User;
use App\Entities\ModelMonitor;
class UserPermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->createExecutive();
        $this->createManager();
        $this->createOperational();
        $this->createStaff();
    }
    
    public function tearDown()
    {
        $deletedRows = User::where('id', '>', 1)->delete();
    }
    
    public function testViewAdmin()
    {
        $this->be(User::where('email', 'admin@alientronics.com.br')->first());
        
        $this->visit('/')->see('Monitores');
    
        $this->visit('/modelmonitor')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testViewExecutive()
    {
        $this->be(User::where('email', 'executive@alientronics.com.br')->first());
    
        $this->visit('/')->see('Monitores', true);
    
        $this->visit('/modelmonitor')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateAdmin()
    {
        $this->be(User::where('email', 'admin@alientronics.com.br')->first());
        
        $this->visit('/modelmonitor')->see('Novo');
        
        $this->visit('/modelmonitor/create')
            ->type('Nome Monitor Teste', 'name')
            ->type('1', 'version')
            ->press('Enviar')
            ->seePageIs('/modelmonitor')
        ;
        
        $this->seeInDatabase('model_monitors', ['name' => 'Nome Monitor Teste', 'version' => '1']);
    }
    
    public function testCreateExecutive()
    {
        $this->be(User::where('email', 'executive@alientronics.com.br')->first());
    
        $this->visit('/modelmonitor')->see('Novo', true);
    
        $this->visit('/modelmonitor/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateAdmin()
    {
        $this->be(User::where('email', 'admin@alientronics.com.br')->first());
        
        $this->visit('/modelmonitor/'.ModelMonitor::all()->last()['id'].'/edit')
            ->type('Nome Monitor Editado', 'name')
            ->type(2, 'version')
            ->press('Enviar')
        ;
        
        $this->seeInDatabase('model_monitors', ['name' => 'Nome Monitor Editado', 'version' => '2']);
    }
    
    public function testUpdateExecutive()
    {
        $this->be(User::where('email', 'executive@alientronics.com.br')->first());
    
        $this->visit('/modelmonitor')
            ->see('Editar', true)
        ;
        
        $this->visit('/modelmonitor/'.ModelMonitor::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteAdmin()
    {
        $this->be(User::where('email', 'admin@alientronics.com.br')->first());
        
        $this->visit('/modelmonitor')
            ->press('Excluir');
    
        $this->notSeeInDatabase('model_monitors', ['name' => 'Nome Monitor Editado', 'version' => '2']);
    }
    
    public function testDeleteExecutive()
    {
        $this->be(User::where('email', 'executive@alientronics.com.br')->first());
    
        $this->visit('/modelmonitor')
            ->see('Excluir', true)
        ;
    }
}
