<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ModelVehicle extends Model implements Transformable
{
    use TransformableTrait;
    public $timestamps = false;
    
    protected $fillable = ['name', 'type_vehicle_id', 'year', 'number_of_wheels'];

    public function typeVehicle()
    {
        return $this->belongsTo("App\Entities\TypeVehicle");
    }
}
