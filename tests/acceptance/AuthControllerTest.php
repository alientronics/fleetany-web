<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use Illuminate\Support\Facades\Auth;

class AuthControllerTest extends AcceptanceTestCase
{
    public function testCreate()
    {
        Auth::logout();
        $this->assertEquals(false, $this->isAuthenticated());
        
        $this->visit('/')->see('Please Sign In');
        
        $this->type('admin@alientronics.com.br', 'email')
            ->type('admin', 'password')
            ->press('Log in')
        ;
        
        $this->assertEquals(true, $this->isAuthenticated());
    }
    
    public function testCreateAccount()
    {
        $rememberToken = str_random(10);
        $user = factory(\App\Entities\User::class)->create([
            'remember_token' => $rememberToken
        ]);
        
        $this->visit('/create-account/'.$rememberToken)
            ->type('123456', 'password')
            ->press('Log in')
            ->seePageIs('/')
            ->see('Painel de Frota')
        ;
    }
    
    public function testCreateAccountInvalidToken()
    {
        $rememberToken = str_random(10);
        
        $this->visit('/create-account/'.$rememberToken)
            ->seePageIs('/auth/login')
            ->see('O token utilizado')
        ;
    }
    
    public function testCreateAccountInvalidPassword()
    {
        $rememberToken = str_random(10);
        $user = factory(\App\Entities\User::class)->create([
            'remember_token' => $rememberToken
        ]);
        
        $this->visit('/create-account/'.$rememberToken)
            ->type('12345', 'password')
            ->press('Log in')
            ->seePageIs('/create-account/'.$rememberToken)
            ->see('invalidpassword')
        ;
    }
}
