<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TypeVehicleControllerRepository;
use App\Entities\TypeVehicleController;

/**
 * Class TypeVehicleControllerRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TypeVehicleControllerRepositoryEloquent extends BaseRepository implements TypeVehicleControllerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TypeVehicleController::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
