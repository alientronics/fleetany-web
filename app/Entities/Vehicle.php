<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Vehicle extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'vehicles';
    protected $fillable = ['model_vehicle_id', 'number', 'initial_miliage',
                            'actual_miliage', 'cost', 'description'];


    public function company()
    {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(\App\Entities\Model::class, 'model_vehicle_id', 'id');
    }

    public function trips()
    {
        return $this->hasMany(\App\Entities\Trip::class, 'vehicle_id', 'id');
    }

    public function entries()
    {
        return $this->hasMany(\App\Entities\Entry::class, 'vehicle_id', 'id');
    }

    public function parts()
    {
        return $this->hasMany(\App\Entities\Part::class, 'vehicle_id', 'id');
    }

    public function partsHistories()
    {
        return $this->hasMany(\App\Entities\PartHistory::class, 'vehicle_id', 'id');
    }
    
    public function checkCompanyRelationships()
    {
        return [
            "model_vehicle_id" => "Model"
        ];
    }
    
    public static function boot()
    {
        parent::boot();
        Vehicle::creating(function ($vehicle) {
            $vehicle->company_id = ( $vehicle->company_id ?: Auth::user()['company_id'] );
        });
    }
}
