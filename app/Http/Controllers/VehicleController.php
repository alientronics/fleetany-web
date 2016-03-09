<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\VehicleRepositoryEloquent;
use App\Entities\Vehicle;
use Log;
use Hash;
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
        'company-id',
        'model-vehicle-id',
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
        $role = $objHelperRepository->getAvailableRoles();
        $language = $objHelperRepository->getAvailableLanguages();
        $model_vehicle_id = $objHelperRepository->getAvailableLanguages();
        return view("vehicle.edit", compact('vehicle', 'model_vehicle_id', 'role', 'language'));
    }

    public function store()
    {
        try {
            $this->vehicleRepo->validator();
            Input::merge(array('password' => Hash::make(Input::get('password'))));
            $this->vehicleRepo->create(Input::all());
            Vehicle::all()->last()->assignRole(Input::get('role_id'));
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
        $role = $objHelperRepository->getAvailableRoles();
        $language = $objHelperRepository->getAvailableLanguages();
            
        return view("vehicle.edit", compact('vehicle', 'role', 'language'));
    }
    
    public function update($idVehicle)
    {
        try {
            $this->vehicleRepo->validator();
            Input::merge(array('password' => Hash::make(Input::get('password'))));
            $this->vehicleRepo->update(Input::all(), $idVehicle);
            Vehicle::all()->last()->assignRole(Input::get('role_id'));
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
