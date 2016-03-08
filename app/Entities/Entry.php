<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model {

    /**
     * Generated
     */

    protected $table = 'entries';
    protected $fillable = ['id', 'company_id', 'entry_type_id', 'vendor_id', 'datetime_ini', 'datetime_end', 'entry_number', 'cost', 'description'];


    public function company() {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function type() {
        return $this->belongsTo(\App\Entities\Type::class, 'entry_type_id', 'id');
    }

    public function contact() {
        return $this->belongsTo(\App\Entities\Contact::class, 'vendor_id', 'id');
    }


}
