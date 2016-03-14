<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Repositories\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $helper;
    protected $request;
    protected $redirect;
    protected $session;

    public function __construct()
    {
        $this->helper = new HelperRepository();
        $this->request = \App::make('Illuminate\Http\Request');
        $this->redirect = \App::make('Illuminate\Routing\Redirector');
        $this->session = $this->request->session();
    }
}
