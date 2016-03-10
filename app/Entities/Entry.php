<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Entry extends BaseModel {

    /**
     * Generated
     */

    protected $table = 'entries';
    protected $fillable = ['id', 'company_id', 'entry_type_id', 'vendor_id', 'vehicle_id', 'datetime_ini', 'datetime_end', 'entry_number', 'cost', 'description'];


    public function company() {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function type() {
        return $this->belongsTo(\App\Entities\Type::class, 'entry_type_id', 'id');
    }

    public function contact() {
        return $this->belongsTo(\App\Entities\Contact::class, 'vendor_id', 'id');
    }

    public function vehicle() {
        return $this->belongsTo(\App\Entities\Vehicle::class, 'vehicle_id', 'id');
    }


}
