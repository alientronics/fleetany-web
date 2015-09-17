<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class UsersController extends Controller
{
    public function showProfile()
    {
        return View::make('profile');
    }
}
