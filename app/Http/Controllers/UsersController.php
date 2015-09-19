<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{

	public function update($id, Request $request)
	{
		$user = User::findOrFail($id);
	
		$this->validate($request, [
				'name' => 'required',
				'email' => 'required'
				]);
	
		$input = $request->all();
	
		$user->fill($input)->save();
	
		$request->session()->flash('flash_message', 'Altera&ccedil;&otilde;es salvas com sucesso!');
	
		return redirect()->back();
	}
	
    public function showProfile()
    {
    	$task = User::findOrFail(Auth::id());
    	
    	return view('profile')->withUser($task);
    }
}
