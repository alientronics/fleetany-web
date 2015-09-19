<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->be(User::find(1));

        $this->visit('/profile')
            ->type('Nome', 'name')
            ->type('email@email.com.br', 'email')
            ->press('Salvar')
            ->seePageIs('/profile');
        
        $this->seeInDatabase('users', ['id' => 1, 'name' => 'Nome', 'email' => 'email@email.com.br']);
    }
}
