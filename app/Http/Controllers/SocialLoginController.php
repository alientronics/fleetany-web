<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Lang;

class SocialLoginController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';
    protected $redirectAfterLogout = '/';

    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'getLogout']);
    }

    public function redirectToProvider(Request $request, $provider, $token = null)
    {
        $request->session()->flash('token', $token);
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider, Request $request)
    {
        try {
            $user = Socialite::driver($provider)->user();

            if (!empty($request->session()->get('token'))) {
                $userPending = User::where('remember_token', $request->session()->get('token'))
                                    ->first();

                if (empty($userPending) || $userPending->email != $user->email) {
                    if ($provider == 'google') {
                        $request->session()->flash('error', Lang::get("general.LoginGoogleFailed"));
                    } else {
                        $request->session()->flash('error', Lang::get("general.LoginFacebookFailed"));
                    }
                    return redirect('/create-account/'.$request->session()->get('token'));
                }
                
                $userPending->pending_company_id = null;
                $userPending->save();
            }
            
        } catch (\Exception $e) {
            if ($provider == 'google') {
                $request->session()->flash('error', Lang::get("general.LoginGoogleFailed"));
            } else {
                $request->session()->flash('error', Lang::get("general.LoginFacebookFailed"));
            }
            return redirect('/auth/login');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect('/');
    }

    private function findOrCreateUser($user)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }

        $newUser = new User([
            'name' => isset($user->name) ? $user->name : $user->nickname,
            'email' => $user->email,
            'contact_id' => 1,
        ]);
        $newUser->save();
        
        $newUser->setUp();

        return $newUser;
    }
}
