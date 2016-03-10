<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelRepository;
use App\Entities\Model;

class ModelRepositoryEloquent extends BaseRepository implements ModelRepository
{

    protected $rules = [
        'name'      => 'min:3|required',
        ];

    public function model()
    {
        return Model::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function results($filters = array())
    {
        $models = $this->scopeQuery(function ($query) use ($filters) {
            
            if (!empty($filters['company-id'])) {
                $query = $query->where('company_id', $filters['company-id']);
            }
            if (!empty($filters['model-type-id'])) {
                $query = $query->where('model_type_id', $filters['model-type-id']);
            }
            if (!empty($filters['vendor-id'])) {
                $query = $query->where('vendor_id', $filters['vendor-id']);
            }
            if (!empty($filters['name'])) {
                $query = $query->where('name', $filters['name']);
            }

            $query = $query->orderBy($filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $models;
    }
}
