<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\VehicleRepositoryEloquent;
use App\Entities\Vehicle;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CompanyRepositoryEloquent;
use App\Repositories\ModelRepositoryEloquent;

class VehicleController extends Controller
{

    protected $vehicleRepo;
    
    protected $fields = [
        'id',
        'model-vehicle',
        'number',
        'cost'
    ];
    
    public function __construct(VehicleRepositoryEloquent $vehicleRepo)
    {
        parent::__construct();
        
        $this->middleware('auth');
        $this->vehicleRepo = $vehicleRepo;
    }

    public function index()
    {
        $filters = $this->helper->getFilters($this->request->all(), $this->fields, $this->request);
        
        $vehicles = $this->vehicleRepo->results($filters);
                
        return view("vehicle.index", compact('vehicles', 'filters'));
    }
    
    public function create()
    {
        $vehicle = new Vehicle();
        $company_id = CompanyRepositoryEloquent::getCompanies();
        $model_vehicle_id = ModelRepositoryEloquent::getModelVehicles();
        return view("vehicle.edit", compact('vehicle', 'model_vehicle_id', 'company_id'));
    }

    public function store()
    {
        try {
            $this->vehicleRepo->validator();
            $inputs = $this->request->all();
            $inputs['company_id'] = Auth::user()['company_id'];
            $this->vehicleRepo->create($inputs);
            return $this->redirect->to('vehicle')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.Vehicle')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function edit($idVehicle)
    {
        $vehicle = $this->vehicleRepo->find($idVehicle);
        $this->helper->validateRecord($vehicle);

        $company_id = CompanyRepositoryEloquent::getCompanies();
        $model_vehicle_id = ModelRepositoryEloquent::getModelVehicles();
            
        return view("vehicle.edit", compact('vehicle', 'model_vehicle_id', 'company_id'));
    }
    
    public function update($idVehicle)
    {
        try {
            $vehicle = $this->vehicleRepo->find($idVehicle);
            $this->helper->validateRecord($vehicle);
            $this->vehicleRepo->validator();
            $inputs = $this->request->all();
            $inputs['company_id'] = Auth::user()['company_id'];
            $this->vehicleRepo->update($inputs, $idVehicle);
            return $this->redirect->to('vehicle')->with('message', Lang::get(
                'general.succefullupdate',
                ['table'=> Lang::get('general.Vehicle')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idVehicle)
    {
        $hasReferences = $this->vehicleRepo->hasReferences($idVehicle);
        $vehicle = $this->vehicleRepo->find($idVehicle);
        if ($vehicle && !$hasReferences) {
            $this->helper->validateRecord($vehicle);
            Log::info('Delete field: '.$idVehicle);
            $this->vehicleRepo->delete($idVehicle);
            return $this->redirect->to('vehicle')->with('message', Lang::get("general.deletedregister"));
        } elseif ($hasReferences) {
            return $this->redirect->to('vehicle')->with('message', Lang::get("general.deletedregisterhasreferences"));
        } else {
            return $this->redirect->to('vehicle')->with('message', Lang::get("general.deletedregistererror"));
        }
    }
}
