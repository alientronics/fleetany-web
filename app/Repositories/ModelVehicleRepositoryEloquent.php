<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelVehicleRepository;
use App\Entities\ModelVehicle;

/**
 * Class ModelVehiclesRepositoryEloquent
 *
 * @package namespace App\Repositories;
 */
class ModelVehicleRepositoryEloquent extends BaseRepository implements ModelVehicleRepository
{
    
    /**
     * Specify validator rules
     *
     * @var array
     */
    protected $rules = [
        'name'      => 'min:3|required',
        'year'   => 'digits:4|required',
        'number_of_wheels'   => 'between:1,2|required'
        ];
    
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ModelVehicle::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
