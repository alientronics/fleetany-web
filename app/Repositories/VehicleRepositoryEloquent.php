<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VehicleRepository;
use App\Entities\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Entities\Gps;

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
            $vehicles->splice(0, 0, ["" => ""]);
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
            ->where('gps.company_id', Auth::user()['company_id']);
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
        $deg_per_rad = 57.29578;  // Number of degrees/radian (for conversion)
    
        $distance = ($geofence['radius'] * pi() * sqrt(
            ($vehiclePoint['latitude'] - $geofence['latitude'])
            * ($vehiclePoint['latitude'] - $geofence['latitude'])
            + cos($vehiclePoint['latitude'] / $deg_per_rad)  // Convert these to
            * cos($geofence['latitude'] / $deg_per_rad)  // radians for cos()
            * ($vehiclePoint['longitude'] - $geofence['longitude'])
            * ($vehiclePoint['longitude'] - $geofence['longitude'])
        ) / 180);
    
        return $distance <= $geofence['radius'];  // Returned using the units used for $radius.
    }
    
    private static function getVehiclesGeofence($vehicles)
    {
        if (!empty($vehicles)) {
            foreach ($vehicles as $index => $vehicle) {
                if (empty($vehicle['geofence'])) {
                    $vehicles[$index]['in_geofence'] = true;
                } else {
                    $geofenceJson = json_decode($vehicle['geofence'], true);
                    $geofenceJson = $geofenceJson[0];

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
}
