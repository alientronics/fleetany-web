<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CompanyRepository;
use App\Entities\Company;

class CompanyRepositoryEloquent extends BaseRepository implements CompanyRepository
{

    protected $rules = [
        'name'      => 'min:3|required',
        'api_token'      => 'min:3|required',
        ];

    public function model()
    {
        return Company::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function results($filters = array())
    {
        $companies = $this->scopeQuery(function ($query) use ($filters) {
            
            if (!empty($filters['contact-id'])) {
                $query = $query->where('contact_id', $filters['contact-id']);
            }
            if (!empty($filters['name'])) {
                $query = $query->where('name', $filters['name']);
            }
            if (!empty($filters['measure-units'])) {
                $query = $query->where('measure_units', $filters['measure-units']);
            }
            if (!empty($filters['api-token'])) {
                $query = $query->where('api_token', $filters['api-token']);
            }

            $query = $query->orderBy($filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $companies;
    }
}
