<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelTireControllerRepository;
use App\Entities\ModelTireController;

/**
 * Class ModelTireControllerRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ModelTireControllerRepositoryEloquent extends BaseRepository implements ModelTireControllerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ModelTireController::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
