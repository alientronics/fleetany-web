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
}
