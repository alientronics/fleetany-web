<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Trip extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'trips';
    protected $fillable = ['driver_id', 'vehicle_id', 'vendor_id',
                            'trip_type_id', 'pickup_date', 'pickup_place',
                            'deliver_date', 'deliver_place', 'begin_mileage', 'end_mileage',
                            'total_mileage', 'fuel_cost', 'fuel_amount', 'description'];


    public function company()
    {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function contactDriver()
    {
        return $this->belongsTo(\App\Entities\Contact::class, 'driver_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(\App\Entities\Vehicle::class, 'vehicle_id', 'id');
    }

    public function contactVendor()
    {
        return $this->belongsTo(\App\Entities\Contact::class, 'vendor_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(\App\Entities\Type::class, 'trip_type_id', 'id');
    }
    
    public function checkCompanyRelationships()
    {
        return [
            "driver_id" => "Contact",
            "vehicle_id" => "Vehicle",
            "vendor_id" => "Contact",
            "trip_type_id" => "Type"
        ];
    }
    
    public static function boot()
    {
        parent::boot();
        Trip::creating(function ($trip) {
            if (empty($trip->company_id)) {
                $trip->company_id = Auth::user()['company_id'];
            }
        });
    }
}
