<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TripRepository;
use App\Entities\Trip;
use Carbon\Carbon;
use Log;

class TripRepositoryEloquent extends BaseRepository implements TripRepository
{

    protected $rules = [
        'company_id'    => 'required',
        'vehicle_id'    => 'required',
        'trip_type_id'  => 'required',
        'pickup_date'   => 'required',
        'end_mileage'   => 'required',
        'fuel_cost'     => 'required',
        'fuel_amount'   => 'required',
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

            if ($filters['sort'] == 'trip_type') {
                $sort = 'types.name';
            } elseif ($filters['sort'] == 'vehicle') {
                $sort = 'models.name';
            } else {
                $sort = 'trips.'.$filters['sort'];
            }
            $query = $query->orderBy($sort, $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $trips;
    }
    
    public function getFuelCostMonthStatistics($month, $year)
    {
                
        $cost = Trip::whereRaw('MONTH(pickup_date) = ?', [$month])
                ->whereRaw('YEAR(pickup_date) = ?', [$year])
                ->sum('fuel_cost');
        
        return $cost;
    }
    
    public function getLastsFuelCostStatistics()
    {
        $statistics = array();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $statistics[$date->month] = $this->getFuelCostMonthStatistics($date->month, $date->year);
        }
        
        return $statistics;
    }
    
    public function getTripsStatistics()
    {

        $trips['in_progress']['color'] = '#3871cf';
        $trips['in_progress']['result'] = Trip::where('trips.pickup_date', '<=', Carbon::now())
                ->where(function ($query) {
                    $query->where('deliver_date', '>', Carbon::now())
                          ->orWhereNull('deliver_date');
                })
                ->count();

        $trips['foreseen']['color'] = '#cf7138';
        $trips['foreseen']['result'] = Trip::where('trips.pickup_date', '>', Carbon::now())->count();

        $trips['accomplished']['color'] = '#38cf71';
        $trips['accomplished']['result'] = Trip::where('trips.deliver_date', '<=', Carbon::now())->count();
        
        return $trips;
    }
}
