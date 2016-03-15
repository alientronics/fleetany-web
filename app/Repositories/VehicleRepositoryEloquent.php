<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VehicleRepository;
use App\Entities\Vehicle;

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

            $query = $query->orderBy('vehicles.'.$filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $vehicles;
    }
    
    public static function getVehicles()
    {
        $vehicles = Vehicle::lists('number', 'id');
        return $vehicles;
    }
}
