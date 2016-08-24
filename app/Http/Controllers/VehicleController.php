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
use Alientronics\FleetanyWebAttributes\Repositories\AttributeRepositoryEloquent;
use App\Entities\Contact;
use App\Repositories\TireSensorRepositoryEloquent;
use App\Repositories\FleetRepositoryEloquent;

class VehicleController extends Controller
{

    protected $vehicleRepo;
    protected $partRepo;
    protected $tireSensorRepo;
    protected $fleetRepo;
    
    protected $fields = [
        'id',
        'model-vehicle',
        'fleet',
        'number',
        'cost'
    ];
    
    public function __construct(
        VehicleRepositoryEloquent $vehicleRepo,
        PartRepositoryEloquent $partRepo,
        TireSensorRepositoryEloquent $tireSensorRepo,
        FleetRepositoryEloquent $fleetRepo
    ) {
    
        parent::__construct();
        
        $this->middleware('auth');
        $this->vehicleRepo = $vehicleRepo;
        $this->partRepo = $partRepo;
        $this->tireSensorRepo = $tireSensorRepo;
        $this->fleetRepo = $fleetRepo;
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
            $attributes = AttributeRepositoryEloquent::getAttributes('vehicle');
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

        $partController = new PartController($this->partRepo, $this->tireSensorRepo);
        $filters = $this->helper->getFilters($this->request->all(), $partController->getFields(), $this->request);
        $filters['vehicle_id'] = $vehicle->id;
        $parts = $this->partRepo->results($filters);
        $modeldialog = ModelRepositoryEloquent::getDialogStoreOptions('vehicle');

        $tires = $this->partRepo->getTires();
        $tiresVehicle = $this->partRepo->getTiresVehicle($idVehicle);
        $tiresPositions = $this->partRepo->getTiresPositions($tiresVehicle, $idVehicle);
        
        $part_type_id = $this->partRepo->getTiresTypeId();
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
        $tires = $this->partRepo->getTiresVehicle($vehicle->id);
        $fleetData = $this->fleetRepo->getFleetData($vehicle->id);
        $localizationData = $this->vehicleRepo->getLocalizationData($idVehicle);
        $driverData = empty($localizationData->driver_id) ? "" :
                            Contact::find($localizationData->driver_id);

        return view("vehicle.show", compact(
            'vehicle',
            'fleetData',
            'localizationData',
            'driverData'
        ));
    }
    
    public function updateMapDetail()
    {
        $data = $this->request->all();

        return view("vehicle.map.details", compact(
            'data'
        ));
    }
}
