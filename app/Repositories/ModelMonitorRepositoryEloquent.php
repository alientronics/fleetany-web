<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelMonitorRepository;
use App\Entities\ModelMonitor;

/**
 * Class ModelMonitorsRepositoryEloquent
 *
 * @package namespace App\Repositories;
 */
class ModelMonitorRepositoryEloquent extends BaseRepository implements ModelMonitorRepository
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
        return ModelMonitor::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
