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
use App\Repositories\PartRepositoryEloquent;
use Illuminate\Container\Container as Application;
use Alientronics\FleetanyWebAttributes\Repositories\AttributeRepositoryEloquent;
use App\Entities\Contact;
use Illuminate\Http\Request;

class VehicleController extends Controller
{

    protected $vehicleRepo;
    
    protected $fields = [
        'id',
        'model-vehicle',
        'fleet',
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
        $model_vehicle_id = ModelRepositoryEloquent::getModels('vehicle');
        $parts = null;
        $modeldialog = ModelRepositoryEloquent::getDialogStoreOptions('vehicle');

        $attributes = [];
        if (config('app.attributes_api_url') != null) {
            $attributes = AttributeRepositoryEloquent::getAttributesWithValues('vehicle');
        }
        return view("vehicle.edit", compact(
            'vehicle',
            'model_vehicle_id',
            'company_id',
            'parts',
            'attributes',
            'modeldialog'
        ));
    }

    public function store()
    {
        try {
            $this->vehicleRepo->validator();
            $inputs = $this->vehicleRepo->setInputs($this->request->all());
            $inputs['entity_id'] = $this->vehicleRepo->create($inputs)->id;
            if (config('app.attributes_api_url') != null) {
                AttributeRepositoryEloquent::setValues($inputs);
            }
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
        $model_vehicle_id = ModelRepositoryEloquent::getModels('vehicle');
        
        $vehicleLastPlace = $this->vehicleRepo->getVehiclesLastPlace($idVehicle);
        $vehicleLastPlace = !empty($vehicleLastPlace[0]) ? $vehicleLastPlace[0] : null;

        $partRepo = new PartRepositoryEloquent(new Application);
        $partController = new PartController($partRepo);
        $filters = $this->helper->getFilters($this->request->all(), $partController->getFields(), $this->request);
        $filters['vehicle_id'] = $vehicle->id;
        $parts = $partRepo->results($filters);
        $modeldialog = ModelRepositoryEloquent::getDialogStoreOptions('vehicle');

        $tires = $partRepo->getTires($idVehicle);
        $tiresPositions = $partRepo->getTiresPositions($tires, $idVehicle);
        
        $part_type_id = $partRepo->getTiresTypeId($idVehicle);
        $tiresModels = [];
        if (!empty($part_type_id)) {
            $tiresModels = ModelRepositoryEloquent::getModels('part', $part_type_id);
        }
        
        if (!empty($vehicle->geofence)) {
            $vehicle->geofence = json_decode($vehicle->geofence, true);
        }
        
        $attributes = [];
        if (config('app.attributes_api_url') != null) {
            $attributes = AttributeRepositoryEloquent::getAttributesWithValues(
                'vehicle.'.$vehicle->model->type->name,
                $idVehicle
            );
        }
        
        if (empty($vehicle->model->map)) {
            $vehicle->model->map = str_pad("", 24, "0", STR_PAD_RIGHT);
        } else {
            $vehicle->model->map = substr($vehicle->model->map, 0, 24);
            $vehicle->model->map = str_pad($vehicle->model->map, 24, "0", STR_PAD_RIGHT);
        }
        
        return view("vehicle.edit", compact(
            'vehicle',
            'model_vehicle_id',
            'company_id',
            'part_type_id',
            'vehicleLastPlace',
            'parts',
            'tires',
            'tiresPositions',
            'tiresModels',
            'attributes',
            'filters',
            'modeldialog'
        ));
    }
    
    public function update($idVehicle)
    {
        try {
            $vehicle = $this->vehicleRepo->find($idVehicle);
            $this->helper->validateRecord($vehicle);
            $this->vehicleRepo->validator();
            $inputs = $this->vehicleRepo->setInputs($this->request->all());
            $inputs['entity_id'] = $this->vehicleRepo->update($inputs, $idVehicle)->id;
            if (config('app.attributes_api_url') != null) {
                AttributeRepositoryEloquent::setValues($inputs);
            }
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

    public function show($idVehicle)
    {
        $vehicle = $this->vehicleRepo->find($idVehicle);
        $this->helper->validateRecord($vehicle);
        $partRepo = new PartRepositoryEloquent(new Application);
        $tires = $partRepo->getTires($vehicle->id);
        $tiresPositions = $partRepo->getTiresPositions($tires, $vehicle->id);
        $localizationData = $this->vehicleRepo->getLocalizationData($idVehicle);
        $driverData = empty($localizationData->driver_id) ? "" :
                            Contact::find($localizationData->driver_id);
        
        return view("vehicle.show", compact(
            'vehicle',
            'tiresPositions',
            'localizationData',
            'driverData'
        ));
    }
    
    public function updateMapDetail(Request $request)
    {
        $data = $request->all();

        return view("vehicle.map.details", compact(
            'data'
        ));
    }
}
