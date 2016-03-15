<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ModelRepositoryEloquent;
use App\Entities\Model;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CompanyRepositoryEloquent;
use App\Repositories\TypeRepositoryEloquent;
use App\Repositories\ContactRepositoryEloquent;

class ModelController extends Controller
{

    protected $modelRepo;
    
    protected $fields = [
        'id',
        'model-type',
        'vendor',
        'name'
    ];
    
    public function __construct(ModelRepositoryEloquent $modelRepo)
    {
        parent::__construct();
        
        $this->middleware('auth');
        $this->modelRepo = $modelRepo;
    }

    public function index()
    {
        $filters = $this->helper->getFilters($this->request->all(), $this->fields, $this->request);
        
        $models = $this->modelRepo->results($filters);
                
        return view("model.index", compact('models', 'filters'));
    }
    
    public function create()
    {
        $model = new Model();
        $company_id = CompanyRepositoryEloquent::getCompanies();
        $model_type_id = TypeRepositoryEloquent::getTypes();
        $vendor_id = ContactRepositoryEloquent::getContacts();
        return view("model.edit", compact('model', 'model_type_id', 'company_id', 'vendor_id'));
    }

    public function store()
    {
        try {
            $this->modelRepo->validator();
            $this->modelRepo->create($this->request->all());
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Model')]
                )
            );
            return $this->redirect->to('model');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function show($idModel)
    {
        $model = $this->modelRepo->find($idModel);
        return view("model.show", compact('model'));
    }
    
    public function edit($idModel)
    {
        $model = $this->modelRepo->find($idModel);

        $company_id = CompanyRepositoryEloquent::getCompanies();
        $model_type_id = TypeRepositoryEloquent::getTypes();
        $vendor_id = ContactRepositoryEloquent::getContacts();
        
        return view("model.edit", compact('model', 'model_type_id', 'company_id', 'vendor_id'));
    }
    
    public function update($idModel)
    {
        try {
            $this->modelRepo->validator();
            $this->modelRepo->update($this->request->all(), $idModel);
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Model')]
                )
            );
            return $this->redirect->to('model');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idModel)
    {
        Log::info('Delete field: '.$idModel);

        if ($idModel != 1 && $this->modelRepo->find($idModel)) {
            $this->modelRepo->delete($idModel);
            $this->session->flash('message', Lang::get("general.deletedregister"));
        }
        return $this->redirect->to('model');
    }
}
