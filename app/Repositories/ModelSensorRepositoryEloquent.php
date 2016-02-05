<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelSensorRepository;
use App\Entities\ModelSensor;

/**
 * Class ModelSensorRepositoryEloquent
 *
 * @package namespace App\Repositories;
 */
class ModelSensorRepositoryEloquent extends BaseRepository implements ModelSensorRepository
{
    
    /**
     * Specify validator rules
     *
     * @var array
     */
    protected $rules = [
            'name'      => 'min:3|required',
            'version'   => 'required'
        ];
    
    
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ModelSensor::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
