<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
use Hash;
use Lang;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout', 'showCreateAccount', 'createAccount']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create(
            [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]
        );
    }
    
    public function showCreateAccount(Request $request, $token = "")
    {
        $userPending = User::where('remember_token', $token)->first();
    
        if (empty($userPending)) {
            Auth::logout();
            $request->session()->flash('error', Lang::get("general.invalidtoken"));
            return redirect('/auth/login');
        }

        return view("create-account", compact('userPending'));
    }
    
    public function createAccount(Request $request, $token)
    {
        try {
    
            $userPending = User::where('remember_token', $token)->first();
    
            $inputs = $request->all();
    
            if (empty($userPending) || $userPending->email != $inputs['email']) {
                return redirect('/create-account/'.$token)
                ->with('error', Lang::get("general.usernotfound"));
            } elseif (strlen($inputs['password']) < 6) {
                return redirect('/create-account/'.$token)
                ->with('error', Lang::get("general.invalidpassword"));
            }
    
            $userPending->password = Hash::make($inputs['password']);
            $userPending->pending_company_id = null;
            $userPending->save();
    
    
            Auth::login($userPending, true);
    
            return redirect('/');
    
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
            ->with('errors', $e->getMessageBag());
        }
    }
}
