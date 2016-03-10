<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EntryRepository;
use App\Entities\Entry;

class EntryRepositoryEloquent extends BaseRepository implements EntryRepository
{

    protected $rules = [
        'company_id'      => 'required',
        'entry_type_id'   => 'required',
        'datetime_ini'  => 'min:3|required',
        'cost'      => 'min:3|required',
        ];

    public function model()
    {
        return Entry::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function results($filters = array())
    {
        $entries = $this->scopeQuery(function ($query) use ($filters) {

            $query = $query->select('entries.*', 'models.name', 'types.name');
            $query = $query->leftJoin('vehicles', 'entries.vehicle_id', '=', 'vehicles.id');
            $query = $query->leftJoin('models', 'vehicles.model_vehicle_id', '=', 'models.id');
            $query = $query->leftJoin('types', 'entries.entry_type_id', '=', 'types.id');
            
            if (!empty($filters['vehicle-id'])) {
                $query = $query->where('models.name', 'like', '%'.$filters['vehicle-id'].'%');
            }
            if (!empty($filters['entry-type-id'])) {
                $query = $query->where('types.name', 'like', '%'.$filters['entry-type-id'].'%');
            }
            if (!empty($filters['datetime-ini'])) {
                $query = $query->where('entries.datetime_ini', $filters['datetime-ini']);
            }
            if (!empty($filters['cost'])) {
                $query = $query->where('entries.cost', $filters['cost']);
            }

            $query = $query->orderBy('entries.'.$filters['sort'], $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $entries;
    }
}
