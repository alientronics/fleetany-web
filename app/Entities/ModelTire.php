<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ModelTire extends Model implements Transformable
{
    use TransformableTrait;
    public $timestamps = false;

    protected $fillable = ['name', 'pressure_ideal', 'pressure_max', 
        'pressure_min','mileage','temp_ideal','temp_max','temp_min',
        'start_diameter','start_depth','type_land'];

}
