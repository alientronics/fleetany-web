<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserRepository;
use App\Entities\User;
use Illuminate\Support\Facades\Auth;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

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
        $users = $this->scopeQuery(function ($query) use ($filters) {
            
            $query = $query->select('users.*', 'contacts.name', 'companies.name');
            $query = $query->leftJoin('companies', 'users.company_id', '=', 'companies.id');
            $query = $query->leftJoin('contacts', 'users.contact_id', '=', 'contacts.id');
            
            if (!empty($filters['name'])) {
                $query = $query->where('users.name', 'like', '%'.$filters['name'].'%');
            }
            if (!empty($filters['email'])) {
                $query = $query->where('users.email', 'like', '%'.$filters['email'].'%');
            }
            if (!empty($filters['contact-id'])) {
                $query = $query->where('contacts.name', 'like', '%'.$filters['contact-id'].'%');
            }
            if (!empty($filters['company-id'])) {
                $query = $query->where('companies.name', 'like', '%'.$filters['company-id'].'%');
            }
            
            $query = $query->where('users.company_id', Auth::user()['company_id']);
            if ($filters['sort'] == 'contact_id') {
                $sort = 'contacts.name';
            } elseif ($filters['sort'] == 'company_id') {
                $sort = 'companies.name';
            } else {
                $sort = 'users.'.$filters['sort'];
            }
            $query = $query->orderBy($sort, $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $users;
    }
}
