<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserRepository;
use App\Entities\User;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

    protected $fields = [
            'id',
            'name',
            'email',
            'contact-id',
            'company-id',
        ];
    
    protected $rules = [
        'name'      => 'min:3|required',
        ];

    public function model()
    {
        return User::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function results($filters = array())
    {
        $filters['paginate'] = empty($filters['paginate']) ? 1 : $filters['paginate'];
        
        if(empty($filters['sort'])) {
            $filters['sort'] = $this->fields[0];
            $filters['order'] = 'asc';
        } else {
            $sort = explode("-", $filters['sort']);
            $filters['order'] = array_pop($sort);
            $filters['sort'] = implode("-", $sort);
            if(!in_array($filters['sort'], $this->fields)){
                $filters['sort'] = $this->fields[0];
            }
        }
        $filters['sort'] = str_replace("-", "_", $filters['sort']);

        $users = $this->scopeQuery(function($query) use ($filters){
            
            if(!empty($filters['name'])) {
                $query = $query->where('name', $filters['name']);
            }
            if(!empty($filters['email'])) {
                $query = $query->where('email', $filters['email']);
            }
            if(!empty($filters['contact_id'])) {
                $query = $query->where('contact_id', $filters['contact_id']);
            }
            if(!empty($filters['company_id'])) {
                $query = $query->where('company_id', $filters['company_id']);
            }
            
            $query = $query->orderBy($filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $users;
    }
}
