<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelTireRepository;
use App\Entities\ModelTire;

/**
 * Class ModelTireRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ModelTireRepositoryEloquent extends BaseRepository implements ModelTireRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ModelTire::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
