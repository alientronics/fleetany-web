<?php

use App\User;

class UserPermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $userStaffTest = $this->createStaff();
    }
    
    public function testViewAdmin()
    {
        $this->visit('/')->see('user">Usu');
    
        $this->visit('/user')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testViewExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
    
        $this->visit('/')->see('Usu&aacute;rios', true);
    
        $this->visit('/user')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateAdmin()
    {
        $this->visit('/user')->see('Novo');
        
        $this->visit('/user/create');
    
        $idOption = $this->crawler->filterXPath("//select[@id='role_id']/option[5]")->attr('value');
    
        $this->type('Nome Usuario Teste', 'name')
            ->type('teste@alientronics.com.br', 'email')
            ->type('admin', 'password')
            ->select($idOption, 'role_id')
            ->type('Contato Usuario Teste', 'contact_id')
            ->type('Empresa Usuario Teste', 'company_id')
            ->press('Enviar')
            ->seePageIs('/user')
        ;
    
        $this->seeInDatabase('users', ['name' => 'Nome Usuario Teste', 'email' => 'teste@alientronics.com.br']);
        $this->seeInDatabase('role_user', ['role_id' => '5', 'user_id' => User::all()->last()['id']]);
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
        $this->visit('/user/'.User::all()->last()['id'].'/edit');
        
        $idOption = $this->crawler->filterXPath("//select[@id='role_id']/option[3]")->attr('value');
            
        $this->type('Nome Usuario Editado', 'name')
            ->type('emaileditado@usuario.com', 'email')
            ->type('654321', 'password')
            ->select($idOption, 'role_id')
            ->type('Contato Usuario Editado', 'contact_id')
            ->type('Empresa Usuario Editado', 'company_id')
            ->press('Enviar')
        ;
        
        $this->seeInDatabase('users', ['name' => 'Nome Usuario Editado', 'email' => 'emaileditado@usuario.com']);
        $this->seeInDatabase('role_user', ['role_id' => '3', 'user_id' => User::all()->last()['id']]);
    
    }
    
    public function testUpdateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/user')
            ->see('Editar', true)
        ;
        
        $this->visit('/user/'.User::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteAdmin()
    {
        $this->seeInDatabase('users', ['email' => 'staff@alientronics.com.br']);
        $this->visit('/user');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $crawler = $this->click($idOption);
        $this->notSeeInDatabase('users', ['email' => 'staff@alientronics.com.br']);
    }
    
    public function testDeleteExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/user')
            ->see('Excluir', true)
        ;
    }
}
