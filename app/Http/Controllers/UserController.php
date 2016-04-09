<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryEloquent;
use App\Entities\User;
use Hash;
use Input;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CompanyRepositoryEloquent;
use App\Repositories\ContactRepositoryEloquent;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $userRepo;
    
    protected $fields = [
        'id',
        'name',
        'email',
        'contact-id',
        'company-id',
    ];
    
    public function __construct(UserRepositoryEloquent $userRepo)
    {
        parent::__construct();
        
        $this->middleware('auth', ['except' => ['showCreateAccount', 'createAccount']]);
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $filters = $this->helper->getFilters($this->request->all(), $this->fields, $this->request);
        
        $users = $this->userRepo->results($filters);
                
        return view("user.index", compact('users', 'filters'));
    }
    
    public function create()
    {
        $user = new User();
        $role = $this->helper->getAvailableRoles();
        $language = $this->helper->getAvailableLanguages();
        $companies = CompanyRepositoryEloquent::getCompanies();
        $contacts = ContactRepositoryEloquent::getContacts();
        return view("user.edit", compact('user', 'role', 'language', 'companies', 'contacts'));
    }

    public function store()
    {
        try {
            $this->userRepo->validator();
            Input::merge(array('password' => Hash::make(Input::get('password'))));
            $inputs = $this->request->all();
            $inputs['company_id'] = Auth::user()['company_id'];
            $this->userRepo->create($inputs);
            User::all()->last()->assignRole(Input::get('role_id'));
            return $this->redirect->to('user')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.User')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function edit($idUser)
    {
        $user = $this->userRepo->find($idUser);
        $this->helper->validateRecord($user);
        
        $role = $this->helper->getAvailableRoles();
        $language = $this->helper->getAvailableLanguages();
        $companies = CompanyRepositoryEloquent::getCompanies();
        $contacts = ContactRepositoryEloquent::getContacts();
            
        return view("user.edit", compact('user', 'role', 'language', 'companies', 'contacts'));
    }
    
    public function update($idUser)
    {
        try {
            $user = $this->userRepo->find($idUser);
            $this->helper->validateRecord($user);
            $this->userRepo->validator();
            $inputs = $this->userRepo->setInputs($this->request->all(), $user);
            $this->userRepo->update($inputs, $idUser);
            User::all()->last()->assignRole(Input::get('role_id'));
            return $this->redirect->to('user')->with('message', Lang::get(
                'general.succefullupdate',
                ['table'=> Lang::get('general.User')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idUser)
    {
        $user = $this->userRepo->find($idUser);
        if ($idUser != 1 && $user) {
            $this->helper->validateRecord($user);
            Log::info('Delete field: '.$idUser);
            $this->userRepo->delete($idUser);
            return $this->redirect->to('user')->with('message', Lang::get("general.deletedregister"));
        } else {
            return $this->redirect->to('user')->with('message', Lang::get("general.deletedregistererror"));
        }
    }
    
    public function showProfile()
    {
        $user = User::findOrFail(Auth::id());
        $language = $this->helper->getAvailableLanguages();
        return view("profile", compact('user', 'language'));
    }
    
    public function updateProfile($idUser)
    {
        try {
            $user = $this->userRepo->find($idUser);
            $this->userRepo->validator();
            $inputs = $this->userRepo->setInputs($this->request->all(), $user);
            $this->userRepo->update($inputs, $idUser);
            $this->session->put('language', Input::get('language'));
            app()->setLocale(Input::get('language'));
            return $this->redirect->to('profile')->with('message', Lang::get(
                'general.succefullupdate',
                ['table'=> Lang::get('general.User')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
            ->with('errors', $e->getMessageBag());
        }
    }
    
    public function showInvite()
    {
        return view("invite");
    }
    
    public function storeInvite()
    {
        try {
            $this->userRepo->validator();
            $inputs = $this->request->all();
            $inputs['name'] = explode("@", $inputs['email'])[0];
            $inputs['company_id'] = Auth::user()['company_id'];
            $inputs['pending_company_id'] = Auth::user()['company_id'];
            $this->userRepo->create($inputs);
            User::all()->last()->assignRole('staff');
            $user = User::all()->last();
            $user->createContact($inputs);
            return $this->redirect->to('invite')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.PendingUser')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function showCreateAccount(Request $request, $token = "")
    {
        $userPending = User::where('remember_token', $token)->first();
        
        if (empty($userPending)) {
            $request->session()->flash('error', Lang::get("general.invalidtoken"));
            return redirect('/create-account/'.$token);
        }
        
        return view("create-account", compact('userPending'));
    }
    
    public function createAccount($token)
    {
        try {
            
            $userPending = User::where('remember_token', $token)->first();
            
            $this->userRepo->validator();
            $inputs = $this->request->all();
            
            if (empty($userPending) || $userPending->email != $inputs['email']) {
                return redirect('/create-account/'.$token)
                        ->with('error', Lang::get("general.usernotfound"));
            }
            
            $userPending->password = Hash::make($inputs['password']);
            $userPending->pending_company_id = null;
            $userPending->save();
            
            
            Auth::login($userPending, true);
            
            return $this->redirect->to('/');
            
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
}
