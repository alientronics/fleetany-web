<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ModelRepositoryEloquent;
use App\Entities\Model;
use Log;
use Input;
use Lang;
use Session;
use Redirect;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('auth');
        $this->modelRepo = $modelRepo;
    }

    public function index(Request $request)
    {
        $objHelper = new HelperRepository();
        $filters = $objHelper->getFilters($request->all(), $this->fields, $request);
        
        $models = $this->modelRepo->results($filters);
                
        return view("model.index", compact('models', 'filters'));
    }
    
    public function create()
    {
        $model = new Model();
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        $model_type_id = $objHelperRepository->getModelTypes();
        $vendor_id = $objHelperRepository->getVendors();
        return view("model.edit", compact('model', 'model_type_id', 'company_id', 'vendor_id'));
    }

    public function store()
    {
        try {
            $this->modelRepo->validator();
            $this->modelRepo->create(Input::all());
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Model')]
                )
            );
            return Redirect::to('model');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
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
        
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        $model_type_id = $objHelperRepository->getModelTypes();
        $vendor_id = $objHelperRepository->getVendors();
        
        return view("model.edit", compact('model', 'model_type_id', 'company_id', 'vendor_id'));
    }
    
    public function update($idModel)
    {
        try {
            $this->modelRepo->validator();
            $this->modelRepo->update(Input::all(), $idModel);
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Model')]
                )
            );
            return Redirect::to('model');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idModel)
    {
        Log::info('Delete field: '.$idModel);

        if ($idModel != 1 && $this->modelRepo->find($idModel)) {
            $this->modelRepo->delete($idModel);
            Session::flash('message', Lang::get("general.deletedregister"));
        }
        return Redirect::to('model');
    }
}
