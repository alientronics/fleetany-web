<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class User extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name', 'email', 'contact_id', 'password', 'company_id','created_at','updated_at'];
    protected $hidden = ['remember_token'];

    public function contact()
    {
        return $this->belongsTo("App\Entities\TypeVehicle");
    }

    public function company()
    {
        return $this->belongsTo("App\Entities\TypeVehicle");
    }
}
