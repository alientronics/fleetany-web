<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Part extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'parts';
    protected $fillable = ['vehicle_id', 'vendor_id', 'part_type_id', 'part_model_id',
                            'part_id', 'cost', 'name', 'number',
                            'miliage', 'position', 'lifecycle',
                          ];


    public function company()
    {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }
    
    public function vehicle()
    {
        return $this->belongsTo(\App\Entities\Vehicle::class, 'vehicle_id', 'id');
    }
    
    public function vendor()
    {
        return $this->belongsTo(\App\Entities\Contact::class, 'vendor_id', 'id');
    }

    public function partType()
    {
        return $this->belongsTo(\App\Entities\Type::class, 'part_type_id', 'id');
    }

    public function partModel()
    {
        return $this->belongsTo(\App\Entities\Model::class, 'part_model_id', 'id');
    }

    public function part()
    {
        return $this->belongsTo(\App\Entities\Part::class, 'part_id', 'id');
    }

    public function parts()
    {
        return $this->hasMany(\App\Entities\Part::class, 'part_id', 'id');
    }
    
    public function partEntries()
    {
        return $this->hasMany(\App\Entities\PartEntry::class, 'part_id', 'id');
    }

    public function partsHistories()
    {
        return $this->hasMany(\App\Entities\PartHistory::class, 'part_id', 'id');
    }

    public function tireSensors()
    {
        return $this->hasMany(\App\Entities\TireSensor::class, 'part_id', 'id');
    }
    
    public static function boot()
    {
        parent::boot();
        Part::creating(function ($parts) {
            $parts->company_id = ( $parts->company_id ?: Auth::user()['company_id'] );
        });
    }
}
