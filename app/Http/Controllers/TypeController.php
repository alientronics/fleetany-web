<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\TypeRepositoryEloquent;
use App\Entities\Type;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CompanyRepositoryEloquent;

class TypeController extends Controller
{

    protected $typeRepo;
    
    protected $fields = [
        'id',
        'entity-key',
        'name'
    ];
    
    public function __construct(TypeRepositoryEloquent $typeRepo)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->typeRepo = $typeRepo;
    }

    public function index()
    {
        $filters = $this->helper->getFilters($this->request->all(), $this->fields, $this->request);
        
        $types = $this->typeRepo->results($filters);
                
        return view("type.index", compact('types', 'filters'));
    }
    
    public function create()
    {
        $type = new Type();
        $company_id = CompanyRepositoryEloquent::getCompanies();
        return view("type.edit", compact('type', 'company_id'));
    }

    public function store()
    {
        try {
            $this->typeRepo->validator();
            $inputs = $this->request->all();
            $inputs['company_id'] = Auth::user()['company_id'];
            $this->typeRepo->create($inputs);
            return $this->redirect->to('type')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.Type')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function edit($idType)
    {
        $type = $this->typeRepo->find($idType);
        $this->helper->validateRecord($type);

        $company_id = CompanyRepositoryEloquent::getCompanies();
            
        return view("type.edit", compact('type', 'company_id'));
    }
    
    public function update($idType)
    {
        try {
            $type = $this->typeRepo->find($idType);
            $this->helper->validateRecord($type);
            $this->typeRepo->validator();
            $inputs = $this->request->all();
            $inputs['company_id'] = Auth::user()['company_id'];
            $this->typeRepo->update($inputs, $idType);
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Type')]
                )
            );
            return $this->redirect->to('type');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idType)
    {
        Log::info('Delete field: '.$idType);

        $type = $this->typeRepo->find($idType);
        if ($type) {
            $this->helper->validateRecord($type);
            $this->typeRepo->delete($idType);
        }
        return $this->redirect->to('type')->with('message', Lang::get("general.deletedregister"));
    }
}
