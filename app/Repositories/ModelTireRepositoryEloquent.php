<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelTireRepository;
use App\Entities\ModelTire;

/**
 * Class ModelTireRepositoryEloquent
 *
 * @package namespace App\Repositories;
 */
class ModelTireRepositoryEloquent extends BaseRepository implements ModelTireRepository
{
    
    /**
     * Specify validator rules
     *
     * @var array
     */
    protected $rules = [
        'name'      => 'min:3|alpha_num|required',
        //'year'   => 'digits:4|required',
        //'number_of_wheels'   => 'between:1,2|required'
        ];
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
