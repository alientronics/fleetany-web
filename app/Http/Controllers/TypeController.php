<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\TypeRepositoryEloquent;
use App\Entities\Type;
use Log;
use Input;
use Lang;
use Session;
use Redirect;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{

    protected $typeRepo;
    
    protected $fields = [
        'id',
        'company-id',
        'name'
    ];
    
    public function __construct(TypeRepositoryEloquent $typeRepo)
    {
        $this->middleware('auth');
        $this->typeRepo = $typeRepo;
    }

    public function index(Request $request)
    {
        $objHelper = new HelperRepository();
        $filters = $objHelper->getFilters($request->all(), $this->fields, $request);
        
        $types = $this->typeRepo->results($filters);
                
        return view("type.index", compact('types', 'filters'));
    }
    
    public function create()
    {
        $type = new Type();
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        return view("type.edit", compact('type', 'company_id'));
    }

    public function store()
    {
        try {
            $this->typeRepo->validator();
            $this->typeRepo->create(Input::all());
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Type')]
                )
            );
            return Redirect::to('type');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function show($idType)
    {
        $type = $this->typeRepo->find($idType);
        return view("type.show", compact('type'));
    }
    
    public function edit($idType)
    {
        $type = $this->typeRepo->find($idType);
        
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
            
        return view("type.edit", compact('type', 'company_id'));
    }
    
    public function update($idType)
    {
        try {
            $this->typeRepo->validator();
            $this->typeRepo->update(Input::all(), $idType);
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Type')]
                )
            );
            return Redirect::to('type');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idType)
    {
        Log::info('Delete field: '.$idType);

        if ($idType != 1 && $this->typeRepo->find($idType)) {
            $this->typeRepo->delete($idType);
            Session::flash('message', Lang::get("general.deletedregister"));
        }
        return Redirect::to('type');
    }
}
