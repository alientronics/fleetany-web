<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelSensorRepository;
use App\Entities\ModelSensor;

class ModelSensorRepositoryEloquent extends BaseRepository implements ModelSensorRepository
{
    
    protected $rules = [
            'name'      => 'min:3|required',
            'version'   => 'required'
        ];
    
    public function model()
    {
        return ModelSensor::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
