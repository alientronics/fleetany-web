<?php

class UserTest extends TestCase
{
    public function testCreate()
    {
        $idOption = $this->crawler->filterXPath("//select[@id='role_id']/option[1]")->attr('value');
        
        $this->visit('/user/create')
            ->type('Nome Usuario Teste', 'name')
            ->type('email@usuario.com', 'email')
            ->type('123456', 'password')
            ->select($idOption, 'role_id')
            ->type('Contato Usuario Teste', 'contact_id')
            ->type('Empresa Usuario Teste', 'company_id')
            ->press('Enviar')
            ->seePageIs('/user')
        ;

        $this->seeInDatabase('users', ['name' => 'Nome Usuario Teste', 'email' => 'email@usuario.com']);
        $this->seeInDatabase('role_user', ['role_id' => '1', 'user_id' => '2']);
        $this->seeInDatabase('role_user', ['role_id' => '2', 'user_id' => '2']);
        $this->seeInDatabase('role_user', ['role_id' => '3', 'user_id' => '2']);
        $this->seeInDatabase('role_user', ['role_id' => '4', 'user_id' => '2']);
        $this->seeInDatabase('role_user', ['role_id' => '5', 'user_id' => '2']);
    }
    
    public function testUpdate()
    {
        $idOption = $this->crawler->filterXPath("//select[@id='role_id']/option[3]")->attr('value');
        
        $this->visit('/user')
            ->click('Nome Usuario Teste')
            ->type('Nome Usuario Editado', 'name')
            ->type('emaileditado@usuario.com', 'email')
            ->type('654321', 'password')
            ->select($idOption, 'role_id')
            ->type('Contato Usuario Editado', 'contact_id')
            ->type('Empresa Usuario Editado', 'company_id')
            ->press('Enviar')
        ;
        
        $this->seeInDatabase('users', ['name' => 'Nome Usuario Editado', 'email' => 'emaileditado@usuario.com']);
        $this->notSeeInDatabase('role_user', ['role_id' => '1', 'user_id' => '2']);
        $this->notSeeInDatabase('role_user', ['role_id' => '2', 'user_id' => '2']);
        $this->seeInDatabase('role_user', ['role_id' => '3', 'user_id' => '2']);
        $this->seeInDatabase('role_user', ['role_id' => '4', 'user_id' => '2']);
        $this->seeInDatabase('role_user', ['role_id' => '5', 'user_id' => '2']);
    }
    
    public function testDelete()
    {
        $this->visit('/user')
            ->press('Excluir');
        
        $this->notSeeInDatabase('users', ['name' => 'Nome Usuario Editado', 'email' => 'emaileditado@usuario.com']);
    }
    
}
