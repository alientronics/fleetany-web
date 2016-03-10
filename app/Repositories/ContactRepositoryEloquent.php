<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContactRepository;
use App\Entities\Contact;

class ContactRepositoryEloquent extends BaseRepository implements ContactRepository
{

    protected $rules = [
        'company_id'      => 'required',
        'contact_type_id'   => 'required',
        'name'      => 'min:3|required',
        'license_no'  => 'required',
        ];

    public function model()
    {
        return Contact::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function results($filters = array())
    {
        $contacts = $this->scopeQuery(function ($query) use ($filters) {
            
            if (!empty($filters['name'])) {
                $query = $query->where('name', $filters['name']);
            }
            if (!empty($filters['contact-type-id'])) {
                $query = $query->where('contact_type_id', $filters['contact-type-id']);
            }
            if (!empty($filters['city'])) {
                $query = $query->where('city', $filters['city']);
            }

            $query = $query->orderBy($filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $contacts;
    }
}
