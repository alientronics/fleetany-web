<?php

use App\User;

class UserControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $userStaffTest = $this->createStaff();
    }
    
    public function testView()
    {
        $this->visit('/')->see('user">Usu');
    
        $this->visit('/user')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/user')->see('Novo');
        
        $this->visit('/user/create');
    
        $idOption = $this->crawler->filterXPath("//select[@id='role_id']/option[5]")->attr('value');
    
        $this->type('Nome Usuario Teste', 'name')
            ->type('teste@alientronics.com.br', 'email')
            ->type('admin', 'password')
            ->select($idOption, 'role_id')
            ->type('1', 'contact_id')
            ->type('1', 'company_id')
            ->press('Enviar')
            ->seePageIs('/user')
        ;
    
        $this->seeInDatabase('users', ['name' => 'Nome Usuario Teste', 'email' => 'teste@alientronics.com.br']);
        $this->seeInDatabase('role_user', ['role_id' => '5', 'user_id' => User::all()->last()['id']]);
    }
    
    public function testUpdate()
    {
        $this->visit('/user/'.User::all()->last()['id'].'/edit');
        
        $idOption = $this->crawler->filterXPath("//select[@id='role_id']/option[3]")->attr('value');
            
        $this->type('Nome Usuario Editado', 'name')
            ->type('emaileditado@usuario.com', 'email')
            ->type('654321', 'password')
            ->select($idOption, 'role_id')
            ->type('1', 'contact_id')
            ->type('1', 'company_id')
            ->press('Enviar')
        ;
        
        $this->seeInDatabase('users', ['name' => 'Nome Usuario Editado', 'email' => 'emaileditado@usuario.com']);
        $this->seeInDatabase('role_user', ['role_id' => '3', 'user_id' => User::all()->last()['id']]);
    }
    
    public function testDelete()
    {
        $this->seeInDatabase('users', ['email' => 'staff@alientronics.com.br']);
        $this->visit('/user');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $crawler = $this->click($idOption);
        $this->seeIsSoftDeletedInDatabase('users', ['email' => 'staff@alientronics.com.br']);
    }
    
    public function testProfile()
    {
        $this->notSeeInDatabase('users', ['name' => 'Administrator2', 'email' => 'admin2@alientronics.com.br', 'language' => 'en']);
        
        $this->visit('/profile');
        
        $this->type('Administrator2', 'name')
            ->type('admin2@alientronics.com.br', 'email')
            ->select('en', 'language')
            ->press('Enviar')
        ;
        $this->seeInDatabase('users', ['name' => 'Administrator2', 'email' => 'admin2@alientronics.com.br', 'language' => 'en']);
    }
}
