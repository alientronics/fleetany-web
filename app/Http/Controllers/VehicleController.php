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
            $this->vehicleRepo->create($this->request->all());
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Vehicle')]
                )
            );
            return $this->redirect->to('vehicle');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function show($idVehicle)
    {
        $vehicle = $this->vehicleRepo->find($idVehicle);
        return view("vehicle.show", compact('vehicle'));
    }
    
    public function edit($idVehicle)
    {
        $vehicle = $this->vehicleRepo->find($idVehicle);

        $company_id = CompanyRepositoryEloquent::getCompanies();
        $model_vehicle_id = ModelRepositoryEloquent::getModelVehicles();
            
        return view("vehicle.edit", compact('vehicle', 'model_vehicle_id', 'company_id'));
    }
    
    public function update($idVehicle)
    {
        try {
            $this->vehicleRepo->validator();
            $this->vehicleRepo->update($this->request->all(), $idVehicle);
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Vehicle')]
                )
            );
            return $this->redirect->to('vehicle');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idVehicle)
    {
        Log::info('Delete field: '.$idVehicle);

        if ($idVehicle != 1 && $this->vehicleRepo->find($idVehicle)) {
            $this->vehicleRepo->delete($idVehicle);
            $this->session->flash('message', Lang::get("general.deletedregister"));
        }
        return $this->redirect->to('vehicle');
    }
}
