<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryEloquent;
use App\User;
use Hash;
use Input;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('auth');
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
        return view("user.edit", compact('user', 'role', 'language'));
    }

    public function store()
    {
        try {
            $this->userRepo->validator();
            Input::merge(array('password' => Hash::make(Input::get('password'))));
            $this->userRepo->create($this->request->all());
            User::all()->last()->assignRole(Input::get('role_id'));
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.User')]
                )
            );
            return $this->redirect->to('user');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function show($idUser)
    {
        $user = $this->userRepo->find($idUser);
        return view("user.show", compact('user'));
    }
    
    public function edit($idUser)
    {
        $user = $this->userRepo->find($idUser);
        
        $role = $this->helper->getAvailableRoles();
        $language = $this->helper->getAvailableLanguages();
            
        return view("user.edit", compact('user', 'role', 'language'));
    }
    
    public function update($idUser)
    {
        try {
            $this->userRepo->validator();
            Input::merge(array('password' => Hash::make(Input::get('password'))));
            $this->userRepo->update($this->request->all(), $idUser);
            User::all()->last()->assignRole(Input::get('role_id'));
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.User')]
                )
            );
            return $this->redirect->to('user');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idUser)
    {
        Log::info('Delete field: '.$idUser);

        if ($idUser != 1 && $this->userRepo->find($idUser)) {
            $this->userRepo->delete($idUser);
            $this->session->flash('message', Lang::get("general.deletedregister"));
        }
        return $this->redirect->to('user');
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
            $this->userRepo->validator();
            $this->userRepo->update($this->request->all(), $idUser);
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.User')]
                )
            );
            return $this->redirect->to('profile');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
            ->with('errors', $e->getMessageBag());
        }
    }
}
