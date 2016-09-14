<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Service extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'services';
    protected $fillable = ['description', 'name', 'price'];


    public function company()
    {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function checkCompanyRelationships()
    {
        return [];
    }
    
    public static function boot()
    {
        parent::boot();
        Service::creating(function ($service) {
            $service->company_id = ( $service->company_id ?: Auth::user()['company_id'] );
        });
    }
}
