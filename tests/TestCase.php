<?php

use App\User;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    
    public function setUp()
    {
        parent::setUp();
        $this->be(User::find(1));
//         $this->createExecutive();
//         $this->createManager();
//         $this->createOperational();
//         $this->createStaff();
    }
    
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
    
    public function createExecutive()
    {
        $this->visit('/user/create');
    
        $idOption = $this->crawler->filterXPath("//select[@id='role_id']/option[2]")->attr('value');
    
        $this->type('Nome Usuario Executive', 'name')
            ->type('executive@alientronics.com.br', 'email')
            ->type('admin', 'password')
            ->select($idOption, 'role_id')
            ->type('Contato Usuario Teste', 'contact_id')
            ->type('Empresa Usuario Teste', 'company_id')
            ->press('Enviar')
            ->seePageIs('/user')
        ;
    
        $this->seeInDatabase('users', ['name' => 'Nome Usuario Teste', 'email' => 'executive@alientronics.com.br']);
        $this->notSeeInDatabase('role_user', ['role_id' => '1', 'user_id' => User::all()->last()['id']]);
        $this->seeInDatabase('role_user', ['role_id' => '2', 'user_id' => User::all()->last()['id']]);
        $this->seeInDatabase('role_user', ['role_id' => '3', 'user_id' => User::all()->last()['id']]);
        $this->seeInDatabase('role_user', ['role_id' => '4', 'user_id' => User::all()->last()['id']]);
        $this->seeInDatabase('role_user', ['role_id' => '5', 'user_id' => User::all()->last()['id']]);
    }
    
    public function createManager()
    {
        $this->visit('/user/create');
    
        $idOption = $this->crawler->filterXPath("//select[@id='role_id']/option[3]")->attr('value');
    
        $this->type('Nome Usuario Manager', 'name')
            ->type('manager@alientronics.com.br', 'email')
            ->type('admin', 'password')
            ->select($idOption, 'role_id')
            ->type('Contato Usuario Teste', 'contact_id')
            ->type('Empresa Usuario Teste', 'company_id')
            ->press('Enviar')
            ->seePageIs('/user')
        ;
    
        $this->seeInDatabase('users', ['name' => 'Nome Usuario Manager', 'email' => 'manager@alientronics.com.br']);
        $this->notSeeInDatabase('role_user', ['role_id' => '1', 'user_id' => User::all()->last()['id']]);
        $this->notSeeInDatabase('role_user', ['role_id' => '2', 'user_id' => User::all()->last()['id']]);
        $this->seeInDatabase('role_user', ['role_id' => '3', 'user_id' => User::all()->last()['id']]);
        $this->seeInDatabase('role_user', ['role_id' => '4', 'user_id' => User::all()->last()['id']]);
        $this->seeInDatabase('role_user', ['role_id' => '5', 'user_id' => User::all()->last()['id']]);
    }
    
    public function createOperational()
    {
        $this->visit('/user/create');
    
        $idOption = $this->crawler->filterXPath("//select[@id='role_id']/option[4]")->attr('value');
    
        $this->type('Nome Usuario Operational', 'name')
            ->type('operational@alientronics.com.br', 'email')
            ->type('admin', 'password')
            ->select($idOption, 'role_id')
            ->type('Contato Usuario Teste', 'contact_id')
            ->type('Empresa Usuario Teste', 'company_id')
            ->press('Enviar')
            ->seePageIs('/user')
        ;
    
        $this->seeInDatabase('users', ['name' => 'Nome Usuario Operational', 'email' => 'operational@alientronics.com.br']);
        $this->notSeeInDatabase('role_user', ['role_id' => '1', 'user_id' => User::all()->last()['id']]);
        $this->notSeeInDatabase('role_user', ['role_id' => '2', 'user_id' => User::all()->last()['id']]);
        $this->notSeeInDatabase('role_user', ['role_id' => '3', 'user_id' => User::all()->last()['id']]);
        $this->seeInDatabase('role_user', ['role_id' => '4', 'user_id' => User::all()->last()['id']]);
        $this->seeInDatabase('role_user', ['role_id' => '5', 'user_id' => User::all()->last()['id']]);
    }
    
    public function createStaff()
    {
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
        $this->notSeeInDatabase('role_user', ['role_id' => '1', 'user_id' => User::all()->last()['id']]);
        $this->notSeeInDatabase('role_user', ['role_id' => '2', 'user_id' => User::all()->last()['id']]);
        $this->notSeeInDatabase('role_user', ['role_id' => '3', 'user_id' => User::all()->last()['id']]);
        $this->notSeeInDatabase('role_user', ['role_id' => '4', 'user_id' => User::all()->last()['id']]);
        $this->seeInDatabase('role_user', ['role_id' => '5', 'user_id' => User::all()->last()['id']]);
    }
}
