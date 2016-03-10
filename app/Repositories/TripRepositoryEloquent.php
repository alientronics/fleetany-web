<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TripRepository;
use App\Entities\Trip;

class TripRepositoryEloquent extends BaseRepository implements TripRepository
{

    protected $rules = [
        'company_id'    => 'required',
        'vehicle_id'    => 'required',
        'trip_type_id'  => 'required',
        'pickup_date'   => 'required',
        'end_mileage'   => 'min:3|required',
        'fuel_cost'     => 'min:3|required',
        'fuel_amount'   => 'min:3|required',
        ];

    public function model()
    {
        return Trip::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function results($filters = array())
    {
        $trips = $this->scopeQuery(function ($query) use ($filters) {
            
            if (!empty($filters['description'])) {
                $query = $query->where('description', $filters['description']);
            }

            $query = $query->orderBy($filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $trips;
    }
}
