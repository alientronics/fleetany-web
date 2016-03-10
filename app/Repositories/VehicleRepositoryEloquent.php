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
            
            if (!empty($filters['model-vehicle-id'])) {
                $query = $query->where('model_vehicle_id', $filters['model-vehicle-id']);
            }
            if (!empty($filters['number'])) {
                $query = $query->where('number', $filters['number']);
            }
            if (!empty($filters['cost'])) {
                $query = $query->where('cost', $filters['cost']);
            }

            $query = $query->orderBy($filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $vehicles;
    }
}
