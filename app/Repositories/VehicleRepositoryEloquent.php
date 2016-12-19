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
            $objTire->part_id = $tire->id;
        } else {
            $objTire->part_id = "";
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
    
    protected function setTiresColor($tiresData, $sensor, $objTire)
    {
        if (!empty($tiresData['parts'][$sensor->part_id])
            && ($sensor->pressure > $tiresData['dangerMaxPressure']
                || $sensor->pressure < $tiresData['dangerMinPressure']
                || $sensor->temperature > (int)config('app.tires_danger_temperature'))
            ) {
                $objTire->color = "red";
        } elseif (!empty($tiresData['parts'][$sensor->part_id])
                && ($sensor->pressure > $tiresData['warningMaxPressure']
                    || $sensor->pressure < $tiresData['warningMinPressure']
                    || $sensor->temperature > (int)config('app.tires_warning_temperature'))
                ) {
            $objTire->color = "yellow";
        } else {
            $objTire->color = "green";
        }
    
            return $objTire;
    }
    
    protected function getTiresWarningAndDanger($sensorsIds)
    {
    

//         $sensors = \DB::select('part_id', \DB::raw('AVG(temperature) as avg_temperature'))
//             ->from(

//                 TireSensor::select('part_id', 'temperature')

//                 ) as 't'
//             ->groupBy('part_id')
//             ->get();

        $sensorsReturn = [];
    
        $warningPressure = ((int)config('app.tires_warning_pressure_percentage') *
            (int)config('app.tires_ideal_pressure')) / 100;
    
        $sensorsReturn['warningMinPressure'] = (int)config('app.tires_ideal_pressure') - $warningPressure;
        $sensorsReturn['warningMaxPressure'] = (int)config('app.tires_ideal_pressure') + $warningPressure;

        $dangerPressure = ((int)config('app.tires_danger_pressure_percentage') *
            (int)config('app.tires_ideal_pressure')) / 100;

            $sensorsReturn['dangerMinPressure'] = (int)config('app.tires_ideal_pressure') - $dangerPressure;
            $sensorsReturn['dangerMaxPressure'] = (int)config('app.tires_ideal_pressure') + $dangerPressure;
                 
//         $sensors = \DB::select(\DB::raw('
//             select part_id, avg(temperature) as avg_temperature, avg(pressure) as avg_pressure
//             from (

//                 select part_id, temperature, pressure
//                 from tire_sensor
//                 where (
//                     select count(*) from tire_sensor as p
//                     where p.part_id = tire_sensor.part_id and p.created_at >= tire_sensor.created_at
//                     and p.part_id in ('.implode(',',$parts).')
//                     ) <= 3
//             ) as t
//             group by part_id'));
    
        $sensors = TireSensor::select('part_id', 'temperature as avg_temperature', 'pressure as avg_pressure')
            ->whereIn('tire_sensor.id', $sensorsIds)
            ->get();

        if (!empty($sensors)) {
            foreach ($sensors as $sensor) {
                $sensorsReturn['parts'][$sensor->part_id] = $sensor;
            }
        }

        return $sensorsReturn;
    }
}
