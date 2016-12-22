<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\VehicleRepositoryEloquent;
use App\Entities\Vehicle;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\CompanyRepositoryEloquent;
use App\Repositories\ModelRepositoryEloquent;
use App\Repositories\PartRepositoryEloquent;
use Alientronics\FleetanyWebAttributes\Repositories\AttributeRepositoryEloquent;
use App\Entities\Contact;
use App\Repositories\FleetRepositoryEloquent;
use Alientronics\FleetanyWebReports\Controllers\ReportController;
use App\Repositories\HelperRepository;

class VehicleController extends Controller
{

    protected $vehicleRepo;
    protected $partRepo;
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
        FleetRepositoryEloquent $fleetRepo
    ) {
    
        parent::__construct();
        
        $this->middleware('auth');
        $this->vehicleRepo = $vehicleRepo;
        $this->partRepo = $partRepo;
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

        $fields = [
            'id',
            'vehicle',
            'part-type',
            'cost'
        ];
        $filters = $this->helper->getFilters($this->request->all(), $fields, $this->request);
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

    public function show($idVehicle, $dateIni = null, $dateEnd = null)
    {
        $vehicle = $this->vehicleRepo->find($idVehicle);
        $this->helper->validateRecord($vehicle);
        $fleetData = $this->fleetRepo->getFleetData($vehicle->id);
        $localizationData = $this->vehicleRepo->getLocalizationData($idVehicle);
        $driverData = empty($localizationData->driver_id) ? "" :
                            Contact::find($localizationData->driver_id);

        $fleetData['tireData'] = $this->getFleetSensorDatetimeData($fleetData['tireData']);
       
        if (class_exists('Alientronics\FleetanyWebReports\Controllers\ReportController')) {
            $vehicleHistory = $this->vehicleHistory($fleetData, $dateIni, $dateEnd);
            $tireSensorData = $vehicleHistory['tireSensorData'];
            $dateIni = $vehicleHistory['dateIni'];
            $timeIni = $vehicleHistory['timeIni'];
            $timeEnd = $vehicleHistory['timeEnd'];
        } else {
            $tireSensorData = [];
            $dateIni = "";
            $timeIni = "";
            $timeEnd = "";
        }
  
        return view("vehicle.show", compact(
            'vehicle',
            'fleetData',
            'localizationData',
            'driverData',
            'tireSensorData',
            'dateIni',
            'timeIni',
            'timeEnd'
        ));
    }
    
    public function updateMapDetail()
    {
        $data = $this->request->all();

        return view("vehicle.map.details", compact(
            'data'
        ));
    }
    
    private function vehicleHistory($fleetData, $dateIni, $dateEnd)
    {
        $tireSensorData['positions'] = [];
        $partsIds = [];
        if (!empty($fleetData['tireData'])) {
            foreach ($fleetData['tireData'] as $vehicleData) {
                foreach ($vehicleData as $position => $tireData) {
                    if (!empty($tireData->part_id)) {
                        $tireSensorData['positions'][] = $position;
                        $partsIds[] = $tireData->part_id;
                    }
                }
            }
        }
        
        asort($tireSensorData['positions']);
        
        if (empty($dateIni)) {
            $dateIni = date("Y-m-d H:i:s");
            $dateEnd = date('Y-m-d 23:59:59');
        }
        
        $tireSensorData['data'] = $this->fleetRepo->getTireSensorHistoricalData($partsIds, $dateIni, $dateEnd);
        $tireSensorData['columns'] = [];
        
        if (!empty($tireSensorData['positions'])) {
            $tireSensorData = $this->fleetRepo->setColumnsChart($tireSensorData);
        }
        
        $arrayReturn['timeIni'] = substr($dateIni, 11);
        $arrayReturn['timeEnd'] = substr($dateEnd, 11);
        $arrayReturn['dateIni'] = substr(HelperRepository::date($dateIni, 'app_locale'), 0, 10);
        $arrayReturn['tireSensorData'] = $tireSensorData;
        
        return $arrayReturn;
    }
    
    protected function getFleetSensorDatetimeData($fleetTireData)
    {
        if (!empty($fleetTireData)) {
            foreach ($fleetTireData as $idVehicle => $tireData) {
                $lastDatetimeData = $this->getLastDatetimeData($tireData);
                if (is_array($fleetTireData[$idVehicle])) {
                    $fleetTireData[$idVehicle]['isTireSensorOldData'] = HelperRepository::isOldDate(
                        $lastDatetimeData,
                        config('app.tiresensor_max_elapsed_time_minutes')
                    );
                    $fleetTireData[$idVehicle]['lastDatetimeData'] = HelperRepository::date(
                        $lastDatetimeData,
                        'app_locale'
                    );
                }
            }
        }
        return $fleetTireData;
    }
    
    private function getLastDatetimeData($tireData)
    {
        $lastData = "";
        if (!empty($tireData)) {
            foreach ($tireData as $position => $value) {
                if (is_numeric($position) && !empty($value->created_at)) {
                    $datetime = HelperRepository::date($value->created_at);
                    if (empty($lastData) || $datetime > $lastData) {
                        $lastData = $datetime;
                    }
                }
            }
        }
        return $lastData;
    }
}
