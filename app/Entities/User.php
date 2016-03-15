<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    
    protected $fillable = ['id', 'company_id', 'contact_id', 'pending_company_id',
                            'name', 'email', 'password', 'language','created_at','updated_at'];
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
