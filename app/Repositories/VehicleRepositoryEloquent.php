<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VehicleRepository;
use App\Entities\Vehicle;

class VehicleRepositoryEloquent extends BaseRepository implements VehicleRepository
{

    protected $rules = [
        'name'      => 'min:3|required',
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
            
            if (!empty($filters['name'])) {
                $query = $query->where('name', 'like', '%'.$filters['name'].'%');
            }
            if (!empty($filters['email'])) {
                $query = $query->where('email', 'like', '%'.$filters['email'].'%');
            }
            if (!empty($filters['contact-id'])) {
                $query = $query->where('contact_id', 'like', '%'.$filters['contact-id'].'%');
            }
            if (!empty($filters['company-id'])) {
                $query = $query->where('company_id', 'like', '%'.$filters['company-id'].'%');
            }

            $query = $query->orderBy($filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $vehicles;
    }
}
