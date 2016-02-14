<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TypeVehicleRepository;
use App\Entities\TypeVehicle;

class TypeVehicleRepositoryEloquent extends BaseRepository implements TypeVehicleRepository
{
    
    protected $rules = [
        'name'      => 'min:3|required',
        ];

    public function model()
    {
        return TypeVehicle::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
