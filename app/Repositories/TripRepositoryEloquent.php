<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TripRepository;
use App\Entities\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TripRepositoryEloquent extends BaseRepository implements TripRepository
{

    protected $rules = [
        'vehicle_id'    => 'required',
        'trip_type_id'  => 'required',
        'pickup_date'  => 'date|date_format:Y-m-d H:i:s|required',
        'deliver_date' => 'date|date_format:Y-m-d H:i:s|after:pickup_date',
        'end_mileage'   => 'required',
        'fuel_cost'     => 'required|numeric|min:0',
        'fuel_amount'   => 'required|numeric|min:0',
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

            $query = $query->where('trips.company_id', Auth::user()['company_id']);
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
    
    public static function getFuelCostMonthStatistics($month, $year)
    {
        $prefix = \DB::getTablePrefix();
        
        $cost = Trip::whereRaw('MONTH('.$prefix.'trips.pickup_date) = ?', [$month])
                ->whereRaw('YEAR('.$prefix.'trips.pickup_date) = ?', [$year])
                ->where('trips.company_id', Auth::user()['company_id'])
                ->sum('fuel_cost');
        
        return $cost;
    }
    
    public static function getLastsFuelCostStatistics()
    {
        $statistics = array();
        $date = Carbon::now()->addMonthNoOverflow();
        for ($i = 0; $i < 6; $i++) {
            $date = $date->subMonthNoOverflow();
            $statistics[$date->month] = self::getFuelCostMonthStatistics($date->month, $date->year);
        }

        return array_reverse($statistics, true);
    }
    
    public static function getTripsStatistics()
    {
        $trips['in_progress']['color'] = '#3871cf';
        $trips['in_progress']['result'] = Trip::where('trips.pickup_date', '<=', Carbon::now())
                ->where('trips.company_id', Auth::user()['company_id'])
                ->where(function ($query) {
                    $query->where('deliver_date', '>', Carbon::now())
                          ->orWhereNull('deliver_date');
                })
                ->count();

        $trips['foreseen']['color'] = '#cf7138';
        $trips['foreseen']['result'] = Trip::where('trips.pickup_date', '>', Carbon::now())
                ->where('trips.company_id', Auth::user()['company_id'])
                ->count();

        $trips['accomplished']['color'] = '#38cf71';
        $trips['accomplished']['result'] = Trip::where('trips.deliver_date', '<=', Carbon::now())
                ->where('trips.company_id', Auth::user()['company_id'])
                ->count();
        
        return $trips;
    }
}
