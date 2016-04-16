<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    
    public function termsofservice()
    {
        return view("termsofservice");
    }

    public function privacy()
    {
        return view("privacy");
    }
}
