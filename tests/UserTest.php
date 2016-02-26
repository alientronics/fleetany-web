<?php

use App\User;
class UserTest extends TestCase
{
    public function testCreate()
    {
        $this->visit('/user/create');
        
        $idOption = $this->crawler->filterXPath("//select[@id='role_id']/option[2]")->attr('value');
        
        $this->type('Nome Usuario Teste', 'name')
            ->type('email@usuario.com', 'email')
            ->type('123456', 'password')
            ->select($idOption, 'role_id')
            ->type('Contato Usuario Teste', 'contact_id')
            ->type('Empresa Usuario Teste', 'company_id')
            ->press('Enviar')
            ->seePageIs('/user')
        ;

        $this->seeInDatabase('users', ['name' => 'Nome Usuario Teste', 'email' => 'email@usuario.com']);
        $this->seeInDatabase('role_user', ['role_id' => '2', 'user_id' => User::all()->last()['id']]);
    }
    
    public function testUpdate()
    {
        $user = factory(App\User::class)->create([
            'name' => 'Nome Usuario Teste',
            'email' => 'teste@alientronics.com.br',
            'password' => 'admin',
            'contact_id' => 'Contato Usuario Teste',
            'company_id' => 'Empresa Usuario Teste',
        ]);
        
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
    
    public function testDelete()
    {
        $user = factory(App\User::class)->create([
            'name' => 'Nome Usuario Teste',
            'email' => 'teste@alientronics.com.br',
            'password' => 'admin',
            'contact_id' => 'Contato Usuario Teste',
            'company_id' => 'Empresa Usuario Teste',
        ]);
        
        $this->visit('/user');
        $linkExcluir = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $crawler = $this->click($linkExcluir);
        $this->notSeeInDatabase('users', ['name' => 'Nome Usuario Teste', 'email' => 'teste@alientronics.com.br']);
    }
}
