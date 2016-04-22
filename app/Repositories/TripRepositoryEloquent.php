<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TripRepository;
use App\Entities\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class TripRepositoryEloquent extends BaseRepository implements TripRepository
{

    protected $rules = [
        'vehicle_id'    => 'required',
        'trip_type_id'  => 'required',
        'pickup_date'  => 'date|date_format:Y-m-d H:i:s|required',
        'deliver_date' => 'date|date_format:Y-m-d H:i:s|after:pickup_date',
        'end_mileage'   => 'required',
        'fuel_cost'     => 'required|numeric|min:0.01',
        'fuel_amount'   => 'required|numeric|min:0.01',
        'fuel_type'  => 'required',
        ];

    public function model()
    {
        return Trip::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
  
    public function results($filters = [])
    {
        $filters = $this->formatFilters($filters);
        
        $trips = $this->scopeQuery(function ($query) use ($filters) {

            $query = $query->select(
                'trips.id',
                'models.name as vehicle',
                'types.name as trip-type',
                'trips.pickup_date as pickup-date',
                'trips.fuel_cost as fuel-cost'
            );
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
    
    private function formatFilters($filters = [])
    {
        $filters['pickup-date'] = empty($filters['pickup-date']) ? "" : HelperRepository::date($filters['pickup-date']);
        $filters['fuel-cost'] = empty($filters['fuel-cost']) ? "" : HelperRepository::money($filters['fuel-cost']);
        
        return $filters;
    }
    
    public function getInputs($inputs)
    {
        $inputs['pickup_date'] = HelperRepository::date($inputs['pickup_date'], App::getLocale());
        $inputs['deliver_date'] = HelperRepository::date($inputs['deliver_date'], App::getLocale());
        $inputs['fuel_cost'] = HelperRepository::money($inputs['fuel_cost'], App::getLocale());
        $inputs['fuel_amount'] = HelperRepository::money($inputs['fuel_amount'], App::getLocale());
        return $inputs;
    }
    
    public function setInputs($inputs)
    {
        if (empty($inputs['vendor_id'])) {
            unset($inputs['vendor_id']);
        }
        $inputs['pickup_date'] = HelperRepository::date($inputs['pickup_date']);
        $inputs['deliver_date'] = HelperRepository::date($inputs['deliver_date']);
        $inputs['fuel_cost'] = HelperRepository::money($inputs['fuel_cost']);
        $inputs['fuel_amount'] = HelperRepository::money($inputs['fuel_amount']);
        return $inputs;
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
        $statistics = [];
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
