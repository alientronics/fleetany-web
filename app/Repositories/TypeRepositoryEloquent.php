<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TypeRepository;
use App\Entities\Type;
use Illuminate\Support\Facades\Auth;

class TypeRepositoryEloquent extends BaseRepository implements TypeRepository
{

    protected $rules = [
        'name'      => 'min:3|required',
        ];

    public function model()
    {
        return Type::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function results($filters = array())
    {
        $types = $this->scopeQuery(function ($query) use ($filters) {

            $query = $query->select('types.*', 'types.entity_key as entity-key');
            
            if (!empty($filters['entity-key'])) {
                $query = $query->where('entity_key', 'like', '%'.$filters['entity-key'].'%');
            }
            if (!empty($filters['name'])) {
                $query = $query->where('name', 'like', '%'.$filters['name'].'%');
            }

            $query = $query->where('company_id', Auth::user()['company_id']);
            $query = $query->orderBy($filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $types;
    }
    
    public function hasReferences($idType)
    {
        $type = $this->find($idType);
        $countReferences = $type->contacts()->count();
        $countReferences += $type->entries()->count();
        $countReferences += $type->models()->count();
        $countReferences += $type->trips()->count();
        
        if ($countReferences > 0) {
            return true;
        }
        return false;
    }
    
    public static function getTypes($entity_key = null)
    {
        $types = Type::where('company_id', Auth::user()['company_id']);
        
        if (!empty($entity_key)) {
            $types = $types->where('entity_key', $entity_key);
        }
        
        $types = $types->lists('name', 'id');
        
        return $types;
    }
}
