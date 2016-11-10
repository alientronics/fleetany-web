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
                'types.name as part_type',
                'parts.cost as cost'
            );
            $query = $query->leftJoin('vehicles', 'parts.vehicle_id', '=', 'vehicles.id');
            $query = $query->leftJoin('models', 'vehicles.model_vehicle_id', '=', 'models.id');
            $query = $query->leftJoin('types', 'parts.part_type_id', '=', 'types.id');

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
            if (!empty($filters['name'])) {
                $query = $query->where('parts.name', 'like', '%'.$filters['name'].'%');
            }
            if (!empty($filters['number'])) {
                $query = $query->where('parts.number', 'like', '%'.$filters['number'].'%');
            }
            if (!empty($filters['position'])) {
                $query = $query->where('parts.position', $filters['position']);
            }

            $query = $query->where('parts.company_id', Auth::user()['company_id']);
            
            $sort = $this->getResultsSort($filters);
            $query = $query->orderBy($sort, $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $this->setPositions($parts);
    }
    
    private function setPositions($parts)
    {
        if (!empty($parts)) {
            foreach ($parts as $index => $part) {
                if ($part->part_type != "tire" && $part->part_type != "sensor") {
                    $parts[$index]['position'] = "";
                }
            }
        }
        return $parts;
    }
    
    private function getResultsSort($filters)
    {
        if ($filters['sort'] == 'part_type') {
            return 'types.name';
        } elseif ($filters['sort'] == 'vehicle') {
            return 'models.name';
        }
        return 'parts.'.$filters['sort'];
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
        $inputs['entity_key'] = "part";
        if (empty($inputs['vehicle_id'])) {
            unset($inputs['vehicle_id']);
        }
        if (empty($inputs['vendor_id'])) {
            unset($inputs['vendor_id']);
        }
        if (empty($inputs['part_id']) || $inputs['part_id'] == $inputs['current_part_id']) {
            unset($inputs['part_id']);
        }
        if (empty($inputs['cost'])) {
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
        if (!empty($part_id2)) {
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
                'position' => $data['position'],
                'vehicle_id' => $data['vehicle_id']
            ]);
    
        return true;
    }
    
    public function tiresDetails($data)
    {
        if (!empty($data['position'])) {
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
    
    private function getPartIdByTirePosition($position, $vehicle_id)
    {
        $part = Part::select('id')
            ->where('position', $position)
            ->where('vehicle_id', $vehicle_id)
            ->where('company_id', Auth::user()['company_id'])
            ->first();

        return empty($part->id) ? "" : $part->id;
    }
    
    public function getTires()
    {
        $results = Part::select('parts.*', 'models.name as tire_model')
            ->join('models', 'parts.part_model_id', '=', 'models.id')
            ->join('types', 'parts.part_type_id', '=', 'types.id')
            ->where(function ($queryPosition) {
                $queryPosition->whereNull('parts.position')
                    ->orWhere('parts.position', 0)
                    ->orWhere('parts.position', '');
            })
            
            ->where('parts.company_id', Auth::user()['company_id'])
            ->where('types.name', 'tire')
            ->orderBy('position', 'asc')
            ->get();
        
        return $results;
    }
    
    public static function getTiresVehicle($vehicle_id = null)
    {
        $results = Part::select('parts.*', 'models.name as tire_model')
            ->join('vehicles', 'parts.vehicle_id', '=', 'vehicles.id')
            ->join('models', 'parts.part_model_id', '=', 'models.id')
            ->join('types', 'parts.part_type_id', '=', 'types.id');
        
        if (!empty($vehicle_id)) {
            $results = $results->where('parts.vehicle_id', $vehicle_id);
        }
            
         $results = $results->where('parts.company_id', Auth::user()['company_id'])
            ->where('types.name', 'tire')
            ->orderBy('position', 'asc')
            ->get();
        
        return $results;
    }
    
    public static function getTiresPositions($tires, $idVehicle)
    {
        $tiresPositions = [];
        $tiresPositions['max_position'] = 0;
        if (!empty($tires)) {
            foreach ($tires as $tire) {
                if (!empty($tire->vehicle_id) && $tire->vehicle_id == $idVehicle
                        && !empty($tire->position) && $tire->position > 0) {
                    $tiresPositions[$tire->position] = true;
                    
                    if ($tiresPositions['max_position'] < $tire->position) {
                        $tiresPositions['max_position'] = $tire->position;
                    }
                }
            }
        }
        
        return $tiresPositions;
    }
    
    public function getTiresTypeId()
    {
        $result = Part::select('types.id')
            ->join('models', 'parts.part_model_id', '=', 'models.id')
            ->join('types', 'parts.part_type_id', '=', 'types.id')
            ->where('parts.company_id', Auth::user()['company_id'])
            ->where('types.name', 'tire')
            ->first();
        
        if (!empty($result->id)) {
            return $result->id;
        } else {
            return null;
        }
    }
}
