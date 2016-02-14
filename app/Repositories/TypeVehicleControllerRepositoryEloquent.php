<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TypeVehicleControllerRepository;
use App\Entities\TypeVehicleController;

class TypeVehicleControllerRepositoryEloquent extends BaseRepository implements TypeVehicleControllerRepository
{

    public function model()
    {
        return TypeVehicleController::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
