<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TypeVehicleRepository;
use App\Entities\TypeVehicle;

/**
 * Class TypeVehicleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TypeVehicleRepositoryEloquent extends BaseRepository implements TypeVehicleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TypeVehicle::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
