<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CompanyRepositoryEloquent;
use App\Repositories\TypeRepositoryEloquent;
use App\Repositories\ContactRepositoryEloquent;
use App\Repositories\ModelRepositoryEloquent;
use App\Repositories\VehicleRepositoryEloquent;

class SocialLoginController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';
    protected $redirectAfterLogout = '/';

    protected $companyRepo;
    protected $typeRepo;
    protected $contactRepo;
    protected $modelRepo;
    protected $vehicleRepo;
    
    public function __construct(CompanyRepositoryEloquent $companyRepo,
        TypeRepositoryEloquent $typeRepo,
        ContactRepositoryEloquent $contactRepo,
        ModelRepositoryEloquent $modelRepo,
        VehicleRepositoryEloquent $vehicleRepo
        )
    {
        //$this->middleware('guest', ['except' => 'getLogout']);
        $this->companyRepo = $companyRepo;
        $this->typeRepo = $typeRepo;
        $this->contactRepo = $contactRepo;
        $this->modelRepo = $modelRepo;
        $this->vehicleRepo = $vehicleRepo;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/auth/'.$provider);
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
        
        $newUser->setUp($this->companyRepo, $this->typeRepo, $this->contactRepo, $this->modelRepo, $this->vehicleRepo);

        return $newUser;
    }
}
