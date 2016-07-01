<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PartRepository;
use App\Entities\Part;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Lang;

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
                'parts.*',
                'models.name as vehicle',
                'types.name as part-type',
                'parts.cost as cost',
                'part_models.name as tire-model'
            );
            $query = $query->leftJoin('vehicles', 'parts.vehicle_id', '=', 'vehicles.id');
            $query = $query->leftJoin('models', 'vehicles.model_vehicle_id', '=', 'models.id');
            $query = $query->leftJoin('types', 'parts.part_type_id', '=', 'types.id');
            $query = $query->leftJoin('models as part_models', 'parts.part_model_id', '=', 'part_models.id');

            if (!empty($filters['vehicle_id'])) {
                $query = $query->where('vehicles.id', $filters['vehicle_id']);
            }
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
        if(empty($inputs['cost'])) {
            unset($inputs['cost']);
        } else {
            $inputs['cost'] = HelperRepository::money($inputs['cost']);
        }
        return $inputs;
    }
    
    public static function getPartsByVehicle($vehicle_id)
    {
        $parts = Part::select('*')->where('company_id', Auth::user()['company_id'])
                    ->where('vehicle_id', $vehicle_id)
                    ->get();
        
        return $parts;
    }

    public function tiresPositionSwap($data)
    {
        $parts = [];
        $parts[] = $this->getPartIdByTirePosition($data['position1'], $data['vehicle_id']);
        $part_id2 = $this->getPartIdByTirePosition($data['position2'], $data['vehicle_id']);
        if(!empty($part_id2)) {
            $parts[] = $part_id2;
            sort($parts);
            
            $partsQuery = Part::select('position')
                ->whereIn('id', $parts)
                ->where('company_id', Auth::user()['company_id'])
                ->orderBy('id', 'asc')
                ->get();
        
            Part::where('id', $parts[0])
                ->where('company_id', Auth::user()['company_id'])
                ->update([
                    'position' => $partsQuery[1]['position']
                ]);
        
            Part::where('id', $parts[1])
                ->where('company_id', Auth::user()['company_id'])
                ->update([
                    'position' => $partsQuery[0]['position']
                ]);
        } else {
            Part::where('id', $parts[0])
                ->where('company_id', Auth::user()['company_id'])
                ->update([
                    'position' => $data['position2']
                ]);
        }
    
        return true;
    }
    
    public function tiresPositionRemove($data)
    {
        Part::where('id', $this->getPartIdByTirePosition($data['position'], $data['vehicle_id']))
            ->where('company_id', Auth::user()['company_id'])
            ->update([
                'position' => 0
            ]);
    
        return true;
    }
    
    public function tiresPositionAdd($data)
    {
        Part::where('id', $data['part_id'])
            ->where('company_id', Auth::user()['company_id'])
            ->update([
                'position' => $data['position']
            ]);
    
        return true;
    }
    
    public function tiresDetails($data)
    {
        if(!empty($data['position'])) {
            $part_id = $this->getPartIdByTirePosition($data['position'], $data['vehicle_id']);
        } else {
            $part_id = $data['part_id'];
        }
        
        $part = Part::select('parts.*', 'models.name as tire_model')
            ->join('models', 'parts.part_model_id', '=', 'models.id')
            ->where('parts.id', $part_id)
            ->where('parts.company_id', Auth::user()['company_id'])
            ->get();
        
        return $part;
    }
    
    private function getPartIdByTirePosition($position, $vehicle_id) {
        $part = Part::select('id')
            ->where('position', $position)
            ->where('vehicle_id', $vehicle_id)
            ->where('company_id', Auth::user()['company_id'])
            ->first();

        return empty($part->id) ? "" : $part->id;
    }
    
    public function getTiresPositions($vehicle_id)
    {
        $results = Part::select('position')
            ->join('vehicles', 'parts.vehicle_id', '=', 'vehicles.id')
            ->join('models', 'parts.part_model_id', '=', 'models.id')
            ->join('types', 'parts.part_type_id', '=', 'types.id')
            ->where('parts.vehicle_id', $vehicle_id)
            ->where('parts.position', '>', 0)
            ->where('parts.company_id', Auth::user()['company_id'])
            ->where('types.name', Lang::get('setup.tire'))
            ->orderBy('position', 'asc')
            ->get();
        
        $tires = [];
        if(!empty($results)) {
            foreach ($results as $result) {
                $tires[$result->position] = true;
            }
        }
            
        return $tires;
    }
    
    public function getTiresTypeId($vehicle_id)
    {
        $result = Part::select('types.id')
            ->join('vehicles', 'parts.vehicle_id', '=', 'vehicles.id')
            ->join('models', 'parts.part_model_id', '=', 'models.id')
            ->join('types', 'parts.part_type_id', '=', 'types.id')
            ->where('parts.vehicle_id', $vehicle_id)
            ->where('parts.company_id', Auth::user()['company_id'])
            ->where('types.name', Lang::get('setup.tire'))
            ->first();
        
        if(!empty($result->id)) {
            return $result->id;
        } else {
            return null;
        }
    }
}
