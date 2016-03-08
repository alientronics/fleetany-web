<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model {

    /**
     * Generated
     */

    protected $table = 'trips';
    protected $fillable = ['id', 'company_id', 'driver_id', 'vehicle_id', 'vendor_id', 'trip_type_id', 'pickup_date', 'deliver_date', 'pickup_place', 'deliver_place', 'begin_mileage', 'end_mileage', 'total_mileage', 'fuel_cost', 'fuel_amount', 'description'];


    public function company() {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function contactDriver() {
        return $this->belongsTo(\App\Entities\Contact::class, 'driver_id', 'id');
    }

    public function vehicle() {
        return $this->belongsTo(\App\Entities\Vehicle::class, 'vehicle_id', 'id');
    }

    public function contactVendor() {
        return $this->belongsTo(\App\Entities\Contact::class, 'vendor_id', 'id');
    }

    public function type() {
        return $this->belongsTo(\App\Entities\Type::class, 'trip_type_id', 'id');
    }


}
