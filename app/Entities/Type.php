<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'types';
    protected $fillable = ['id', 'entity_key', 'company_id', 'name'];


    public function company()
    {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany(\App\Entities\Contact::class, 'contact_type_id', 'id');
    }

    public function entries()
    {
        return $this->hasMany(\App\Entities\Entry::class, 'entry_type_id', 'id');
    }

    public function models()
    {
        return $this->hasMany(\App\Entities\Model::class, 'model_type_id', 'id');
    }

    public function trips()
    {
        return $this->hasMany(\App\Entities\Trip::class, 'trip_type_id', 'id');
    }
}
