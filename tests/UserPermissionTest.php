<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserPermissionTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testViewAdmin()
    {
        $this->visit('/')->see('Usu&aacute;rios');
    
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
    
        $this->type('Nome Usuario Staff', 'name')
            ->type('staff@alientronics.com.br', 'email')
            ->type('admin', 'password')
            ->select($idOption, 'role_id')
            ->type('Contato Usuario Teste', 'contact_id')
            ->type('Empresa Usuario Teste', 'company_id')
            ->press('Enviar')
            ->seePageIs('/user')
        ;
    
        $this->seeInDatabase('users', ['name' => 'Nome Usuario Staff', 'email' => 'staff@alientronics.com.br']);
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
        $userStaffTest = $this->createStaff();
        
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
        $userStaffTest = $this->createStaff();
        
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
        $userStaffTest = $this->createStaff();
        
        $this->visit('/user')
            ->press('Excluir');
    
        $this->notSeeInDatabase('users', ['name' => 'Nome Usuario Editado', 'version' => '2']);
    }
    
    public function testDeleteExecutive()
    {
        $userStaffTest = $this->createStaff();
        
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/user')
            ->see('Excluir', true)
        ;
    }
}
