<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\User;

class InviteControllerTest extends AcceptanceTestCase
{
    public function testInviteNewUser()
    {
        $lastId = User::all()->last()['id'];
        
        $this->visit('/')->see('invite user');
    
        $this->visit('/invite')
            ->type('invite@alientronics.com.br', 'email')
            ->press('Enviar')
            ->seePageIs('/invite')
            ->see('criado com sucesso')
        ;
        
        $this->assertGreaterThan($lastId, User::all()->last()['id']);
    }

    public function testInviteExistingUser()
    {
        $lastUserId = User::all()->last()['id'];
        $lastRememberToken = User::where('email', 'admin@alientronics.com.br')
                                ->first()['remember_token'];
        
        $this->visit('/')->see('invite user');
    
        $this->visit('/invite')
            ->type('admin@alientronics.com.br', 'email')
            ->press('Enviar')
            ->seePageIs('/invite')
            ->see('reenviado com sucesso')
        ;

        $this->assertEquals($lastUserId, User::all()->last()['id']);
        $this->assertNotEquals($lastRememberToken, User::all()->last()['remember_token']);
    }
}
