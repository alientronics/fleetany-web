<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelTireControllerRepository;
use App\Entities\ModelTireController;

class ModelTireControllerRepositoryEloquent extends BaseRepository implements ModelTireControllerRepository
{
 
    public function model()
    {
        return ModelTireController::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
