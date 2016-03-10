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
            
            $query = $query->select('companies.*', 'contacts.city', 'contacts.country')->join('contacts', 'companies.contact_id', '=', 'contacts.id');
            
            if (!empty($filters['name'])) {
                $query = $query->where('companies.name', 'like', '%'.$filters['name'].'%');
            }
            if (!empty($filters['city'])) {
                $query = $query->where('contacts.city', 'like', '%'.$filters['city'].'%');
            }
            if (!empty($filters['country'])) {
                $query = $query->where('contacts.country', 'like', '%'.$filters['country'].'%');
            }

            $query = $query->orderBy('companies.'.$filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $companies;
    }
}
