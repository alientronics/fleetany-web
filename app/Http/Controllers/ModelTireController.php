<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ModelTireRepositoryEloquent;
use App\Entities\ModelTire;
use Log;
use Input;
use Lang;
use Session;
use Redirect;
use Response;
use Illuminate\Support\Facades\View;
use Prettus\Validator\Exceptions\ValidatorException;

class ModelTireController extends Controller
{
    
    protected $repository;
    
    public function __construct(ModelTireRepositoryEloquent $repository)
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
        $modeltires = $this->repository->all();
        if (Request::isJson()) {
            return $modeltires;
        }
        return View::make("modeltire.index", compact('modeltires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $modeltire = new ModelTire();
        return view("modeltire.edit", compact('modeltire'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $this->repository->validator();
            $this->repository->create(Input::all());
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.ModelTire')]
                )
            );
            return Redirect::to('modeltire');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $idModelTire
     * @return Response
     */
    public function show($idModelTire)
    {
        $modeltire= $this->repository->find($idModelTire);
        return View::make("modeltire.show", compact('modeltire'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $idModelTire
     * @return Response
     */
    public function edit($idModelTire)
    {
        $modeltire = $this->repository->find($idModelTire);
        return View::make("modeltire.edit", compact('modeltire'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $idModelTire
     * @return Response
     */
    public function update($idModelTire)
    {
        try {
            $this->repository->validator();
            $this->repository->update(Input::all(), $idModelTire);
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.ModelTire')]
                )
            );
            return Redirect::to('modeltire');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $idModelTire
     * @return Response
     */
    public function destroy($idModelTire)
    {
        Log::info('Delete field: '.$idModelTire);
        if ($this->repository->find($idModelTire)) {
            $this->repository->delete($idModelTire);
            Session::flash('message', Lang::get("general.deletedregister"));
        }
        return Redirect::to('modeltire');
    }
}
