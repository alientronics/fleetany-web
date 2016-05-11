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
            $inputs = $this->request->all();
            $this->modelRepo->create($inputs);
            return $this->redirect->to('model')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.Model')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }

    public function edit($idModel)
    {
        $model = $this->modelRepo->find($idModel);
        $this->helper->validateRecord($model);

        $company_id = CompanyRepositoryEloquent::getCompanies();
        $model_type_id = TypeRepositoryEloquent::getTypes();
        $vendor_id = ContactRepositoryEloquent::getContacts();
        
        return view("model.edit", compact('model', 'model_type_id', 'company_id', 'vendor_id'));
    }
    
    public function update($idModel)
    {
        try {
            $model = $this->modelRepo->find($idModel);
            $this->helper->validateRecord($model);
            $this->modelRepo->validator();
            $inputs = $this->request->all();
            $this->modelRepo->update($inputs, $idModel);
            return $this->redirect->to('model')->with('message', Lang::get(
                'general.succefullupdate',
                ['table'=> Lang::get('general.Model')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idModel)
    {
        $hasReferences = $this->modelRepo->hasReferences($idModel);
        $model = $this->modelRepo->find($idModel);
        if ($model && !$hasReferences) {
            $this->helper->validateRecord($model);
            Log::info('Delete field: '.$idModel);
            $this->modelRepo->delete($idModel);
            return $this->redirect->to('model')->with('message', Lang::get("general.deletedregister"));
        } elseif ($hasReferences) {
            return $this->redirect->to('model')->with('message', Lang::get("general.deletedregisterhasreferences"));
        } else {
            return $this->redirect->to('model')->with('message', Lang::get("general.deletedregistererror"));
        }
    }
    
    public function getModelsByType($entityKey = null, $idType = null)
    {
        echo ModelRepositoryEloquent::getModels($entityKey, $idType);
    }
}
