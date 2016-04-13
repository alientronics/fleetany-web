<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryEloquent;
use App\Entities\User;
use Log;
use Lang;
use Mail;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class InviteController extends Controller
{

    protected $userRepo;
    
    public function __construct(UserRepositoryEloquent $userRepo)
    {
        parent::__construct();
        
        $this->middleware('auth');
        $this->userRepo = $userRepo;
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

            $user = User::where('email', $inputs['email'])->first();
            if (!empty($user)) {
                $user->remember_token = str_random(30);
                $user->save();
                $this->sendEmailInvite($user->id);
                return $this->redirect->to('invite')->with('message', Lang::get(
                    'general.invitesucessfullresend'
                ));
            } else {
                $user = new User;
                $user->name = explode("@", $inputs['email'])[0];
                $user->email = $inputs['email'];
                $user->pending_company_id = Auth::user()['company_id'];
                $user->remember_token = str_random(30);
                $user->save();
    
                $user->assignRole('staff');
                $user->createContact($user->name, $user->company_id);
    
                $this->sendEmailInvite($user->id);
                return $this->redirect->to('invite')->with('message', Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.InviteUser')]
                ));
            }
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function sendEmailInvite($idUser)
    {
        $user = User::findOrFail($idUser);
    
        try {
            Mail::send('emails.invite', ['user' => $user], function ($m) use ($user) {
                $m->from(env('MAIL_SENDER'), 'fleetany sender');
        
                $m->to($user->email, $user->name)->subject('fleetany invitation');
            });
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
