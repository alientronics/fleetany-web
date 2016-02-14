<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelMonitorRepository;
use App\Entities\ModelMonitor;

class ModelMonitorRepositoryEloquent extends BaseRepository implements ModelMonitorRepository
{

    protected $rules = [
            'name'      => 'min:3|required',
            'version'   => 'required'
        ];

    public function model()
    {
        return ModelMonitor::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
