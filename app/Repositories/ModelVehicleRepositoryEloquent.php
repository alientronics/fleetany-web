<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelVehicleRepository;
use App\Entities\ModelVehicle;

class ModelVehicleRepositoryEloquent extends BaseRepository implements ModelVehicleRepository
{
    
    protected $rules = [
        'name'      => 'min:3|required',
        'year'   => 'digits:4|required',
        'number_of_wheels'   => 'between:1,2|required'
        ];

    public function model()
    {
        return ModelVehicle::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
