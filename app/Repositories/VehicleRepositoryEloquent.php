<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VehicleRepository;
use App\Entities\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Entities\Gps;
use App\Entities\Part;
use App\Entities\TireSensor;
use Log;

class VehicleRepositoryEloquent extends BaseRepository implements VehicleRepository
{

    protected $rules = [
        'model_vehicle_id'   => 'required',
        'cost'      => 'min:3|required',
        ];

    public function model()
    {
        return Vehicle::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function results($filters = [])
    {
        $filters['cost'] = empty($filters['cost']) ? "" : HelperRepository::money($filters['cost']);
        
        $vehicles = $this->scopeQuery(function ($query) use ($filters) {

            $query = $query->select('vehicles.*', 'models.name as model-vehicle');
            $query = $query->leftJoin('models', 'vehicles.model_vehicle_id', '=', 'models.id');
            
            if (!empty($filters['model-vehicle'])) {
                $query = $query->where('models.name', 'like', '%'.$filters['model-vehicle'].'%');
            }
            if (!empty($filters['number'])) {
                $query = $query->where('vehicles.number', 'like', '%'.$filters['number'].'%');
            }
            if (!empty($filters['cost'])) {
                $query = $query->where('vehicles.cost', 'like', '%'.$filters['cost'].'%');
            }

            $query = $query->where('vehicles.company_id', Auth::user()['company_id']);
            if ($filters['sort'] == 'model_vehicle') {
                $sort = 'models.name';
            } else {
                $sort = 'vehicles.'.$filters['sort'];
            }
            $query = $query->orderBy($sort, $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $vehicles;
    }
    
    public function hasReferences($idVehicle)
    {
        $vehicle = $this->find($idVehicle);
        $countReferences = $vehicle->entries()->count();
        $countReferences += $vehicle->trips()->count();
        
        if ($countReferences > 0) {
            return true;
        }
        return false;
    }
    
    public static function getVehicles($optionalChoice = false)
    {
        $vehicles = Vehicle::where('vehicles.company_id', Auth::user()['company_id'])
                                ->lists('number', 'id');
        
        if ($optionalChoice) {
            $vehicles->prepend("", "");
        }
                                
        return $vehicles;
    }
    
    public static function getVehiclesLastPlace($vehicle_id = null)
    {
        $sub = Gps::select(\DB::raw('MAX(id) as id'))
            ->groupBy('vehicle_id');
        $prefix = \DB::getTablePrefix();

        $vehicles = Gps::select('gps.id', 'vehicle_id', 'latitude', 'longitude', 'geofence')
            ->join(\DB::raw("({$sub->toSql()}) as ".$prefix."gps2"), 'gps.id', '=', 'gps2.id')
            ->join('vehicles', 'vehicles.id', '=', 'gps.vehicle_id')
            ->where('vehicles.company_id', Auth::user()['company_id']);
        if (!empty($vehicle_id)) {
            $vehicles = $vehicles->where('vehicle_id', $vehicle_id);
        }
        $vehicles = $vehicles->groupBy('vehicle_id')
                            ->get();
        
        $vehicles = self::getVehiclesGeofence($vehicles);
        
        return $vehicles;
    }
    
    private static function isVehicleInGeofence($vehiclePoint, $geofence)
    {
        $distance = sqrt(
            pow(($vehiclePoint['latitude'] - $geofence['latitude']), 2)
            + pow(($vehiclePoint['longitude'] - $geofence['longitude']), 2)
        );
    
        return $distance <= $geofence['radius'];
    }
    
    private static function getVehiclesGeofence($vehicles)
    {
        if (!empty($vehicles)) {
            foreach ($vehicles as $index => $vehicle) {
                if (empty($vehicle['geofence'])) {
                    $vehicles[$index]['in_geofence'] = true;
                } else {
                    $geofenceJson = json_decode($vehicle['geofence'], true);
                    $vehicles[$index]['in_geofence'] = self::isVehicleInGeofence($vehicle, $geofenceJson);
                }
            }
        }
        return $vehicles;
    }
    
    public static function getVehiclesStatistics()
    {
        $vehicles['in_use']['color'] = '#3871cf';
        $vehicles['in_use']['result'] = Vehicle::join('trips', 'vehicles.id', '=', 'trips.vehicle_id')
                ->where('vehicles.company_id', Auth::user()['company_id'])
                ->where('trips.pickup_date', '<=', Carbon::now())
                ->where(function ($query) {
                    $query->where('deliver_date', '>', Carbon::now())
                          ->orWhereNull('deliver_date');
                })
                ->count();
            
        $vehicles['maintenance']['color'] = '#cf7138';
        $vehicles['maintenance']['result'] = Vehicle::join('entries', 'vehicles.id', '=', 'entries.vehicle_id')
                ->join('types', 'types.id', '=', 'entries.entry_type_id')
                ->where('vehicles.company_id', Auth::user()['company_id'])
                ->where('types.entity_key', 'vehicle')
                ->where('types.name', 'repair')
                ->where('entries.datetime_ini', '<=', Carbon::now())
                ->where(function ($query) {
                    $query->where('datetime_end', '>', Carbon::now())
                          ->orWhereNull('datetime_end');
                })
                ->count();
        
        $vehicles['available']['color'] = '#38cf71';
        $vehiclesOff = $vehicles['maintenance']['result'] + $vehicles['in_use']['result'];
        $vehicles['available']['result'] = Vehicle::where('vehicles.company_id', Auth::user()['company_id'])
                                            ->count() - $vehiclesOff;
        return $vehicles;
    }
    
    public function setInputs($inputs)
    {
        if (!empty($inputs['geofence_name']) &&
            !empty($inputs['geofence_radius']) && is_numeric($inputs['geofence_radius']) &&
            !empty($inputs['geofence_latitude']) && is_numeric($inputs['geofence_latitude']) &&
            !empty($inputs['geofence_longitude']) && is_numeric($inputs['geofence_longitude'])
        ) {
            $inputs['geofence'] = '{"latitude": '.$inputs['geofence_latitude'].','.
                                    '"longitude": '.$inputs['geofence_longitude'].', '.
                                    '"radius": '.$inputs['geofence_radius'].', '.
                                    '"transitionType": 2, '.
                                    '"notification": { "text": "'.$inputs['geofence_name'].'"} }';
        } else {
            unset($inputs['geofence']);
        }

        $inputs['cost'] = HelperRepository::money($inputs['cost']);
        if ($inputs['cost'] == "0.00") {
            $inputs['cost'] = 0;
        }
        
        $inputs['entity_key'] = "vehicle";
        
        return $inputs;
    }
    
    public function getLocalizationData($idVehicle)
    {
        $localizationData = Gps::where('vehicle_id', $idVehicle)
            ->orderBy('id', 'desc')
            ->first();
        
        return $localizationData;
    }
    
    public function getTireAndSensorData($inputs)
    {
        $tire = Part::join('types', 'parts.part_type_id', '=', 'types.id')
            ->where('parts.position', $inputs['position'])
            ->where('parts.vehicle_id', $inputs['vehicle_id'])
            ->where('parts.company_id', Auth::user()['company_id'])
            ->where('types.name', 'tire')
            ->first();

        $objTire = new \stdClass();
        
        if (!empty($tire)) {
            $sensor = TireSensor::join('parts', 'tire_sensor.part_id', '=', 'parts.id')
                ->join('types', 'parts.part_type_id', '=', 'types.id')
                ->where('parts.part_id', $tire->id)
                ->where('parts.position', $inputs['position'])
                ->where('parts.vehicle_id', $inputs['vehicle_id'])
                ->where('parts.company_id', Auth::user()['company_id'])
                ->where('types.name', 'sensor')
                ->orderBy('parts.id', 'desc')
                ->first();
            
            $objTire->position = HelperRepository::manageEmptyValue($tire->position);
            $objTire->number = HelperRepository::manageEmptyValue($tire->number);
            $objTire->model = HelperRepository::manageEmptyValue($tire->partModel->name);
            $objTire->lifecycle = HelperRepository::manageEmptyValue($tire->lifecycle);
            $objTire->miliage = HelperRepository::manageEmptyValue($tire->miliage);
        } else {
            $objTire->position = "";
            $objTire->number = "";
            $objTire->model = "";
            $objTire->lifecycle = "";
            $objTire->miliage = "";
        }

        if (!empty($sensor)) {
            $objTire->temperature = HelperRepository::manageEmptyValue($sensor->temperature);
            $objTire->pressure = HelperRepository::manageEmptyValue($sensor->pressure);
            $objTire->battery = HelperRepository::manageEmptyValue($sensor->battery);
            $objTire->sensorNumber = HelperRepository::manageEmptyValue($sensor->number);
        } else {
            $objTire->temperature = "";
            $objTire->pressure = "";
            $objTire->battery = "";
            $objTire->sensorNumber = "";
        }
        return $objTire;
    }

    private function getFleetTireAndSensorData($updateDatetime = null)
    {
        $sensors = TireSensor::select('tire_sensor.*', 'parts.position', 'parts.vehicle_id')
            ->join('parts', 'tire_sensor.part_id', '=', 'parts.id')
            ->join('types', 'parts.part_type_id', '=', 'types.id')
            ->whereNotNull('parts.vehicle_id')
            ->where('parts.company_id', Auth::user()['company_id'])
            ->where('types.name', 'sensor');
        
        if(!empty($updateDatetime)) {
            $sensors = $sensors->where('tire_sensor.created_at', '>', $updateDatetime);
        }
            
        $sensors = $sensors->orderBy('tire_sensor.created_at', 'asc')
            ->get();

        $tireAndSensorData = [];
        if (!empty($sensors)) {
            foreach ($sensors as $sensor) {
                $objTire = new \stdClass();
                $objTire->temperature = HelperRepository::manageEmptyValue($sensor->temperature);
                $objTire->pressure = HelperRepository::manageEmptyValue($sensor->pressure);
                
                $tireAndSensorData[$sensor->vehicle_id][$sensor->position] = $objTire;
            }
        }
        $objTire = new \stdClass();
        $objTire->temperature = "";
        $objTire->pressure = "";
        $tireAndSensorData[0] = $objTire;
    
        return $tireAndSensorData;
    }

    private function getFleetGpsData($updateDatetime = null)
    {
        $gpsQuery = Gps::where('company_id', Auth::user()['company_id']);
        
        if(!empty($updateDatetime)) {
            $gpsQuery = $gpsQuery->where('created_at', '>', $updateDatetime);
        }
            
        $gpsQuery = $gpsQuery->orderBy('created_at', 'asc')
            ->get();

        $gpsData = [];
        if (!empty($gpsQuery)) {
            foreach ($gpsQuery as $gps) {
                $objGps = new \stdClass();
                $objGps->latitude = HelperRepository::manageEmptyValue($gps->latitude);
                $objGps->longitude = HelperRepository::manageEmptyValue($gps->longitude);
                
                $gpsData[$gps->vehicle_id] = $objGps;
            }
        }

        return $gpsData;
    }
    
    public function getFleetData()
    {
        $vehicles = Vehicle::where('company_id', Auth::user()['company_id'])->get();
        $tireData = [];
        $modelMaps = [];
        
        if (!empty($vehicles)) {
            $tires = PartRepositoryEloquent::getTiresVehicle();
            $fleetGpsData = $this->getFleetGpsData();
            $tireAndSensorData = $this->getFleetTireAndSensorData();
            foreach ($vehicles as $vehicle) {
                
                if(empty($modelMaps[$vehicle->model_vehicle_id])) {
                    $modelMaps[$vehicle->model_vehicle_id] = $vehicle->model->map;
                }

                $tireData[$vehicle->id] = [];
                $tiresPositions = PartRepositoryEloquent::getTiresPositions($tires, $vehicle->id);
        
                if (!empty($tiresPositions)) {
                    foreach ($tiresPositions as $position => $filled) {
                        if ($filled) {
                            if(!empty($tireAndSensorData[$vehicle->id][$position])) {
                                $tireData[$vehicle->id][$position] = $tireAndSensorData[$vehicle->id][$position];
                            } else {
                                $tireData[$vehicle->id][$position] = $tireAndSensorData[0];
                            }
                        }
                    }
                }

                if(!empty($fleetGpsData[$vehicle->id])) {
                    $gpsData[$vehicle->id] = $fleetGpsData[$vehicle->id];
                } else {
                    $gpsData[$vehicle->id] = [];
                }
            }
        }
        
        return ['vehicles' => $vehicles, 'tireData' => $tireData, 'gpsData' => $gpsData, 'modelMaps' => $modelMaps];
    }
    
    public function getFleetGpsAndSensorData($updateDatetime = null)
    {
        Log::info($updateDatetime);
        return ['updateDatetime' => date("Y-m-d H:i:s"), 'gps' => $this->getFleetGpsData($updateDatetime), 'tires' => $this->getFleetTireAndSensorData($updateDatetime)];
    }
}
