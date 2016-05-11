<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PartRepository;
use App\Entities\Part;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class PartRepositoryEloquent extends BaseRepository implements PartRepository
{

    protected $rules = [
        'part_type_id'  => 'required',
        'part_model_id'  => 'required',
        'cost'     => 'numeric|min:0.01',
        'number'  => 'required',
        ];

    public function model()
    {
        return Part::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
  
    public function results($filters = [])
    {
        $filters = $this->formatFilters($filters);
        
        $parts = $this->scopeQuery(function ($query) use ($filters) {

            $query = $query->select(
                'parts.id',
                'models.name as vehicle',
                'types.name as part-type',
                'parts.cost as cost'
            );
            $query = $query->leftJoin('vehicles', 'parts.vehicle_id', '=', 'vehicles.id');
            $query = $query->leftJoin('models', 'vehicles.model_vehicle_id', '=', 'models.id');
            $query = $query->leftJoin('types', 'parts.part_type_id', '=', 'types.id');
            
            if (!empty($filters['vehicle'])) {
                $query = $query->where('models.name', 'like', '%'.$filters['vehicle'].'%');
            }
            if (!empty($filters['part-type'])) {
                $query = $query->where('types.name', 'like', '%'.$filters['part-type'].'%');
            }
            if (!empty($filters['cost'])) {
                $query = $query->where('parts.cost', $filters['cost']);
            }

            $query = $query->where('parts.company_id', Auth::user()['company_id']);
            if ($filters['sort'] == 'part_type') {
                $sort = 'types.name';
            } elseif ($filters['sort'] == 'vehicle') {
                $sort = 'models.name';
            } else {
                $sort = 'parts.'.$filters['sort'];
            }
            $query = $query->orderBy($sort, $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $parts;
    }
    
    private function formatFilters($filters = [])
    {
        $filters['cost'] = empty($filters['cost']) ? "" : HelperRepository::money($filters['cost']);
        
        return $filters;
    }
    
    public function getInputs($inputs)
    {
        $inputs['cost'] = HelperRepository::money($inputs['cost'], App::getLocale());
        return $inputs;
    }
    
    public function setInputs($inputs)
    {
        if (empty($inputs['vehicle_id'])) {
            unset($inputs['vehicle_id']);
        }
        if (empty($inputs['vendor_id'])) {
            unset($inputs['vendor_id']);
        }
        if (empty($inputs['part_id']) || $inputs['part_id'] == $inputs['current_part_id']) {
            unset($inputs['part_id']);
        }
        $inputs['cost'] = HelperRepository::money($inputs['cost']);
        return $inputs;
    }
    
    public static function getPartsByVehicle($vehicle_id)
    {
        $parts = Part::select('*')->where('company_id', Auth::user()['company_id'])
                    ->where('vehicle_id', $vehicle_id)
                    ->get();
        
        return $parts;
    }
}
