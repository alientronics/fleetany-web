<?php

namespace Tests\Unit;

use Tests\TestCase;

class SocialLoginControllerTest extends TestCase
{

    public function testSocialLogin()
    {
        $user = factory(App\User::class)->create();

        $mockSocialite = Mockery::mock('Laravel\Socialite\Contracts\Factory');
        $this->app->instance('Laravel\Socialite\Contracts\Factory', $mockSocialite);
        $mockSocialDriver = Mockery::mock('Laravel\Socialite\Contracts\Provider');

        $mockSocialite->shouldReceive('driver')->twice()->with('google')->andReturn($mockSocialDriver);
        $mockSocialDriver->shouldReceive('redirect')->once()->andReturn(redirect('/'));
        $mockSocialDriver->shouldReceive('user')->once()->andReturn($user);

        $this->visit('/auth/social/google');
        $this->visit('/auth/google/callback');

        $this->seeInDatabase('users', ['name' => $user->name, 'email' => $user->email]);
    }
}
