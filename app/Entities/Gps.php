<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Gps extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'gps';
    protected $fillable = ['vehicle_id', 'driver_id', 'latitude', 'longitude',
        'accuracy', 'altitude', 'altitudeAccuracy', 'heading', 'speed'
    ];

    public function company()
    {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(\App\Entities\Vehicle::class, 'vehicle_id', 'id');
    }
    
    public static function boot()
    {
        parent::boot();
        Gps::creating(function ($gps) {
            $gps->company_id = ( $gps->company_id ?: Auth::user()['company_id'] );
        });
    }
}
