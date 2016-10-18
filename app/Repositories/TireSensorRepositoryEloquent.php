<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TireSensorRepository;
use App\Entities\TireSensor;
use Illuminate\Support\Facades\App;

class TireSensorRepositoryEloquent extends BaseRepository implements TireSensorRepository
{

    protected $fields = [
        'id',
        'temperature',
        'pressure',
        'battery',
        'latitude',
        'longitude',
        'number',
        'created-at'
    ];

    public function model()
    {
        return TireSensor::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
  
    public function getFields()
    {
        return $this->fields;
    }
    
    public function results($filters = [])
    {
        $tireSensors = $this->scopeQuery(function ($query) use ($filters) {

            $query = $query->select(
                'id',
                'temperature',
                'pressure',
                'battery',
                'latitude',
                'longitude',
                'number',
                'created_at',
                'created_at as created-at'
            );
            
            $query = $query->where('part_id', $filters['id']);
            
            if (!empty($filters['temperature'])) {
                $query = $query->where('temperature', $filters['temperature']);
            }
            if (!empty($filters['pressure'])) {
                $query = $query->where('pressure', $filters['pressure']);
            }
            if (!empty($filters['battery'])) {
                $query = $query->where('battery', $filters['battery']);
            }
            if (!empty($filters['number'])) {
                $query = $query->where('number', 'like', '%'.$filters['number'].'%');
            }

            $query = $query->orderBy($filters['sort'], $filters['order']);
            
            return $query;
        });
        
        if (!empty($filters['paginate']) && $filters['paginate'] == '*') {
            $tireSensors = $tireSensors->all();
        } else {
            $tireSensors = $tireSensors->paginate($filters['paginate']);
        }
        
        return $tireSensors;
    }
}
