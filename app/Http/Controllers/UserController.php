<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\User;
//use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryEloquent;
use App\Entities\User;
use Log;
use Input;
use Lang;
use Session;
use Redirect;
use Response;
use Illuminate\Support\Facades\View;
use Prettus\Validator\Exceptions\ValidatorException;

class UserController extends Controller
{

    protected $repository;
    
    public function __construct(UserRepositoryEloquent $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->repository->all();
        if (Request::isJson()) {
            return $users;
        }
        return View::make("user.index", compact('users'));        //
    }

    public function create()
    {
        $user = new User();
        return view("user.edit", compact('user'));
    }

    public function store(Request $request)
    {
        try {
            $this->repository->validator();
            $this->repository->create(Input::all());
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
    
    public function show($id)
    {
        $typevehicle= $this->repository->find($id);
        return View::make("user.show", compact('user'));
    }
    
    public function edit($id)
    {
        $typevehicle = $this->repository->find($id);
        return View::make("user.edit", compact('user'));
    }
    
//    public function update($userId, Request $request)
//    {
//        $user = User::findOrFail($userId);
//
//        $this->validate(
//            $request, [
//                'name' => 'required',
//                'email' => 'required'
//                ]
//        );
//
//        $input = $request->all();
//
//        $user->fill($input)->save();
//
//        $request->session()->flash('flash_message', 'Altera&ccedil;&otilde;es salvas com sucesso!');
//
//        return redirect()->back();
//    }
//
//    public function showProfile()
//    {
//        $task = User::findOrFail(Auth::id());
//
//        return view('profile')->withUser($task);
//    }
    
    public function update(Request $request, $id)
    {
        try {
            $this->repository->validator();
            $this->repository->update(Input::all(), $id);
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
    
    public function destroy($id)
    {
        Log::info('Delete field: '.$id);

        if ($this->repository->find($id)) {
            $this->repository->delete($id);
            Session::flash('message', Lang::get("general.deletedregister"));
        }
        return Redirect::to('user');
    }
}
