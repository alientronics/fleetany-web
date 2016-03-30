<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VehicleRepository;
use App\Entities\Vehicle;
use Carbon\Carbon;

class VehicleRepositoryEloquent extends BaseRepository implements VehicleRepository
{

    protected $rules = [
        'company_id'      => 'required',
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
    
    public function results($filters = array())
    {
        $vehicles = $this->scopeQuery(function ($query) use ($filters) {

            $query = $query->select('vehicles.*', 'models.name');
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
    
    public static function getVehicles()
    {
        $vehicles = Vehicle::lists('number', 'id');
        return $vehicles;
    }
    
    public static function getVehiclesStatistics()
    {
        $vehicles['in_use']['color'] = '#3871cf';
        $vehicles['in_use']['result'] = Vehicle::join('trips', 'vehicles.id', '=', 'trips.vehicle_id')
                ->where('trips.pickup_date', '<=', Carbon::now())
                ->where(function($query) {
                    $query->where('deliver_date', '>', Carbon::now())
                          ->orWhereNull('deliver_date');
                })
                ->count();
            
        $vehicles['maintenance']['color'] = '#cf7138';
        $vehicles['maintenance']['result'] = Vehicle::join('entries', 'vehicles.id', '=', 'entries.vehicle_id')
                ->join('types', 'types.id', '=', 'entries.entry_type_id')
                ->where('types.entity_key', 'vehicle')
                ->where('types.name', 'repair')
                ->where('entries.datetime_ini', '<=', Carbon::now())
                ->where(function($query) {
                    $query->where('datetime_end', '>', Carbon::now())
                          ->orWhereNull('datetime_end');
                })
                ->where('entries.datetime_ini', '<=', Carbon::now())
                ->count();
        
        $vehicles['available']['color'] = '#38cf71';
        $vehicles['available']['result'] = Vehicle::count() - $vehicles['maintenance']['result'] - $vehicles['in_use']['result'];
        return $vehicles;
    }
}
