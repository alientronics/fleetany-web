<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ModelMonitor extends Model implements Transformable
{
    use TransformableTrait;
    public $timestamps = false;

    protected $fillable = ['name', 'version'];
}
