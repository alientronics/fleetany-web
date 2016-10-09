<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'companies';
    protected $fillable = ['contact_id', 'name', 'measure_units', 'limit_temperature',
        'ideal_pressure', 'delta_pressure', 'alert_date_time'];

    public function contact()
    {
        return $this->belongsTo(\App\Entities\Contact::class, 'contact_id', 'id');
    }
    
    public function contacts()
    {
        return $this->hasMany(\App\Entities\Contact::class, 'company_id', 'id');
    }
        
    public function entries()
    {
        return $this->hasMany(\App\Entities\Entry::class, 'company_id', 'id');
    }

    public function models()
    {
        return $this->hasMany(\App\Entities\Model::class, 'company_id', 'id');
    }

    public function parts()
    {
        return $this->hasMany(\App\Entities\Part::class, 'company_id', 'id');
    }

    public function trips()
    {
        return $this->hasMany(\App\Entities\Trip::class, 'company_id', 'id');
    }

    public function types()
    {
        return $this->hasMany(\App\Entities\Type::class, 'company_id', 'id');
    }

    public function usersCompany()
    {
        return $this->hasMany(\App\Entities\User::class, 'company_id', 'id');
    }

    public function usersPendingCompany()
    {
        return $this->hasMany(\App\Entities\User::class, 'pending_company_id', 'id');
    }

    public function vehicles()
    {
        return $this->hasMany(\App\Entities\Vehicle::class, 'company_id', 'id');
    }
    
    protected static function boot()
    {
        parent::boot();
        Company::creating(function ($company) {
            $company->api_token = str_random(10);
        });
    }
}
