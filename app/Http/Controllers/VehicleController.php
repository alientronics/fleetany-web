<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\VehicleRepositoryEloquent;
use App\Entities\Vehicle;
use Log;
use Input;
use Lang;
use Session;
use Redirect;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('auth');
        $this->vehicleRepo = $vehicleRepo;
    }

    public function index(Request $request)
    {
        $objHelper = new HelperRepository();
        $filters = $objHelper->getFilters($request->all(), $this->fields, $request);
        
        $vehicles = $this->vehicleRepo->results($filters);
                
        return view("vehicle.index", compact('vehicles', 'filters'));
    }
    
    public function create()
    {
        $vehicle = new Vehicle();
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        $model_vehicle_id = $objHelperRepository->getModelVehicles();
        return view("vehicle.edit", compact('vehicle', 'model_vehicle_id', 'company_id'));
    }

    public function store()
    {
        try {
            $this->vehicleRepo->validator();
            $this->vehicleRepo->create(Input::all());
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Vehicle')]
                )
            );
            return Redirect::to('vehicle');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
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
        
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        $model_vehicle_id = $objHelperRepository->getModelVehicles();
            
        return view("vehicle.edit", compact('vehicle', 'model_vehicle_id', 'company_id'));
    }
    
    public function update($idVehicle)
    {
        try {
            $this->vehicleRepo->validator();
            $this->vehicleRepo->update(Input::all(), $idVehicle);
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Vehicle')]
                )
            );
            return Redirect::to('vehicle');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idVehicle)
    {
        Log::info('Delete field: '.$idVehicle);

        if ($idVehicle != 1 && $this->vehicleRepo->find($idVehicle)) {
            $this->vehicleRepo->delete($idVehicle);
            Session::flash('message', Lang::get("general.deletedregister"));
        }
        return Redirect::to('vehicle');
    }
}
