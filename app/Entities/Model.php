<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Model extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'models';
    protected $fillable = ['model_type_id', 'vendor_id', 'name'];


    public function company()
    {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(\App\Entities\Type::class, 'model_type_id', 'id');
    }

    public function contact()
    {
        return $this->belongsTo(\App\Entities\Contact::class, 'vendor_id', 'id');
    }

    public function vehicles()
    {
        return $this->hasMany(\App\Entities\Vehicle::class, 'model_vehicle_id', 'id');
    }
    
    public function checkCompanyRelationships()
    {
        return [
            "model_type_id" => "Type",
            "vendor_id" => "Contact"
        ];
    }
    
    public static function boot()
    {
        parent::boot();
        Model::creating(function ($model) {
            $model->company_id = Auth::user()['company_id'];
        });
    }
}
