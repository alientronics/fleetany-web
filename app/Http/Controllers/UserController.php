<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryEloquent;
use App\Entities\User;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CompanyRepositoryEloquent;
use App\Repositories\ContactRepositoryEloquent;
use Illuminate\Http\Request;
use App\Entities\Contact;
use Illuminate\Container\Container as Application;
use Alientronics\CachedEloquent\Role;

class UserController extends Controller
{

    protected $userRepo;
    protected $contactRepo;
    
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
        
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->contactRepo = new ContactRepositoryEloquent(new Application);
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
        $contact = new Contact();
        $role = $this->helper->getAvailableRoles();
        $language = $user->getAvailableLanguages();
        $companies = CompanyRepositoryEloquent::getCompanies();
        $contacts = ContactRepositoryEloquent::getContacts();
        return view("user.edit", compact('user', 'contact', 'role', 'language', 'companies', 'contacts'));
    }

    public function store()
    {
        try {
            $this->userRepo->validator();
            $this->contactRepo->validator();
            $inputs = $this->userRepo->setInputs($this->request->all());
            
            if ($this->userRepo->checkUserExists($inputs['email'])) {
                return $this->redirect->to('user')->with('message', Lang::get(
                    'general.user_exists'
                ));
            }
            
            $contact = $this->contactRepo->create($inputs);
            $inputs['contact_id'] = $contact->id;
            $this->userRepo->create($inputs);
            User::all()->last()->assignRole($inputs['role_id']);
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
        $role = $user->getRoles()[0];
        $user->role_id = Role::where('slug', $role)->first()->id;
        
        $contact = $this->contactRepo->find($user['contact_id']);
        $this->helper->validateRecord($contact);
        
        $role = $this->helper->getAvailableRoles();
        $language = $user->getAvailableLanguages();
        $companies = CompanyRepositoryEloquent::getCompanies();
        $contacts = ContactRepositoryEloquent::getContacts();
            
        return view("user.edit", compact('user', 'contact', 'role', 'language', 'companies', 'contacts'));
    }
    
    public function update($idUser)
    {
        try {
            $user = $this->userRepo->find($idUser);
            $this->helper->validateRecord($user);
            $this->userRepo->validator();

            $contact = $this->contactRepo->find($user->contact_id);
            $this->helper->validateRecord($contact);
            $this->contactRepo->validator();
            
            $inputs = $this->userRepo->setInputs($this->request->all(), $user);
            $this->userRepo->update($inputs, $idUser);
            User::all()->last()->assignRole($inputs['role_id']);
            $this->contactRepo->update($inputs, $user->contact_id);
            \Cache::flush();
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
        $language = $user->getAvailableLanguages();
        return view("profile", compact('user', 'language'));
    }
    
    public function updateProfile($idUser)
    {
        try {
            $user = $this->userRepo->find($idUser);
            $this->userRepo->validator();
            $inputs = $this->userRepo->setInputs($this->request->all(), $user);
            $this->userRepo->update($inputs, $idUser);
            $this->session->put('language', $inputs['language']);
            app()->setLocale($inputs['language']);
            \Cache::flush();
            return $this->redirect->to('profile')->with('message', Lang::get(
                'general.succefullupdate',
                ['table'=> Lang::get('general.User')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
            ->with('errors', $e->getMessageBag());
        }
    }
}
