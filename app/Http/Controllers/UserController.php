<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryEloquent;
use App\User;
use Log;
use Input;
use Lang;
use Session;
use Redirect;
use Response;
use Illuminate\Support\Facades\View;
use Prettus\Validator\Exceptions\ValidatorException;
use Kodeine\Acl\Models\Eloquent\Role;

class UserController extends Controller
{

    protected $userRepo;
    
    public function __construct(UserRepositoryEloquent $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->userRepo->all();
        if (Request::isJson()) {
            return $users;
        }
        return View::make("user.index", compact('users'));        //
    }

    public function create()
    {
        $user = new User();
        $role = Role::lists('name', 'id');
        
        $role = $role->transform(function ($item, $key) {
            return Lang::get('general.'.$item);
        });
        
        return view("user.edit", compact('user', 'role'));
    }

    public function store()
    {
        try {
            $this->userRepo->validator();
            $this->userRepo->create(Input::all());
            $this->assignRoleToUser(User::all()->last(), Input::get('role_id'));
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.User')]
                )
            );
            return Redirect::to('user');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function show($idUser)
    {
        $user = $this->userRepo->find($idUser);
        return View::make("user.show", compact('user'));
    }
    
    public function edit($idUser)
    {
        $user = $this->userRepo->find($idUser);
        $role = Role::lists('name', 'id');
        
        $role = $role->transform(function ($item, $key) {
            return Lang::get('general.'.$item);
        });
        return View::make("user.edit", compact('user', 'role'));
    }
    
    public function update($idUser)
    {
        try {
            $this->userRepo->validator();
            $this->userRepo->update(Input::all(), $idUser);
            $this->assignRoleToUser(User::find($idUser), Input::get('role_id'));
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.User')]
                )
            );
            return Redirect::to('user');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idUser)
    {
        Log::info('Delete field: '.$idUser);

        if ($this->userRepo->find($idUser)) {
            $this->userRepo->delete($idUser);
            Session::flash('message', Lang::get("general.deletedregister"));
        }
        return Redirect::to('user');
    }
    
    public function assignRoleToUser($user, $idRole)
    {
        $userRoles = array();
        $roles = Role::all()->toArray();
        foreach ($roles as $role) {
            if($idRole <= $role['id']) {
                $userRoles[] = $role['id'];
            }
        }
        $user->syncRoles($userRoles);
    }
    
}
