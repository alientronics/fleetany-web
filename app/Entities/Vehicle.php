<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model {

    /**
     * Generated
     */

    protected $table = 'vehicles';
    protected $fillable = ['id', 'company_id', 'model_vehicle_id', 'number', 'initial_miliage', 'actual_miliage', 'cost', 'description'];


    public function company() {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function model() {
        return $this->belongsTo(\App\Entities\Model::class, 'model_vehicle_id', 'id');
    }

    public function trips() {
        return $this->hasMany(\App\Entities\Trip::class, 'vehicle_id', 'id');
    }

    public function entries() {
        return $this->hasMany(\App\Entities\Entry::class, 'vehicle_id', 'id');
    }


}
