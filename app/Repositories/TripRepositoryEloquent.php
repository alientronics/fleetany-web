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

            $query = $query->select('trips.*', 'models.name', 'types.name');
            $query = $query->leftJoin('vehicles', 'trips.vehicle_id', '=', 'vehicles.id');
            $query = $query->leftJoin('models', 'vehicles.model_vehicle_id', '=', 'models.id');
            $query = $query->leftJoin('types', 'trips.trip_type_id', '=', 'types.id');
            
            if (!empty($filters['vehicle'])) {
                $query = $query->where('models.name', 'like', '%'.$filters['vehicle'].'%');
            }
            if (!empty($filters['trip-type'])) {
                $query = $query->where('types.name', 'like', '%'.$filters['trip-type'].'%');
            }
            if (!empty($filters['pickup-date'])) {
                $query = $query->where('trips.pickup_date', $filters['pickup-date']);
            }
            if (!empty($filters['fuel-cost'])) {
                $query = $query->where('trips.fuel_cost', $filters['fuel-cost']);
            }

            $query = $query->orderBy('trips.'.$filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $trips;
    }
}
