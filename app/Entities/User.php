<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Kodeine\Acl\Traits\HasRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class User extends BaseModel implements Transformable, AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, HasRole, SoftDeletes, TransformableTrait;
    
    protected $fillable = ['contact_id', 'name', 'email', 'password', 'language'];

    public function contact()
    {
        return $this->belongsTo("App\Entities\Contact");
    }

    public function company()
    {
        return $this->belongsTo("App\Entities\Company");
    }
    
    public function setUp()
    {
        $company = Company::forceCreate(['name' => $this->name . ' Inc.']);
        $company->save();
        $this->setUserProperties($company);
        
        Type::forceCreate(['entity_key' => 'entry',
            'name' => Lang::get('setup.repair'),
            'company_id' => $company->id]);
        
        Type::forceCreate(['entity_key' => 'entry',
            'name' => Lang::get('setup.service'),
            'company_id' => $company->id]);
        
        $typeTire = Type::forceCreate(['entity_key' => 'part',
            'name' => Lang::get('setup.tire'),
            'company_id' => $company->id]);
    
        $typeSensor = Type::forceCreate(['entity_key' => 'part',
            'name' => Lang::get('setup.sensor'),
            'company_id' => $company->id]);
        
        $typeCar = Type::forceCreate(['entity_key' => 'vehicle',
            'name' => Lang::get('setup.car'),
            'company_id' => $company->id]);
    
        $typeTruck = Type::forceCreate(['entity_key' => 'vehicle',
            'name' => Lang::get('setup.truck'),
            'company_id' => $company->id]);
    
        $typeVendor = Type::forceCreate(['entity_key' => 'contact',
            'name' => Lang::get('setup.vendor'),
            'company_id' => $company->id]);
    
        $typeDriver = Type::forceCreate(['entity_key' => 'contact',
            'name' => Lang::get('setup.driver'),
            'company_id' => $company->id]);
    
        Type::forceCreate(['entity_key' => 'contact',
            'name' => Lang::get('setup.detail'),
            'company_id' => $company->id]);
    
        Type::forceCreate(['entity_key' => 'fuel',
            'name' => Lang::get('setup.unleaded'),
            'company_id' => $company->id]);
    
        Type::forceCreate(['entity_key' => 'fuel',
            'name' => Lang::get('setup.premium'),
            'company_id' => $company->id]);
    
        Type::forceCreate(['entity_key' => 'trip',
            'name' => Lang::get('setup.tour'),
            'company_id' => $company->id]);
    
        Type::forceCreate(['entity_key' => 'trip',
            'name' => Lang::get('setup.delivery'),
            'company_id' => $company->id]);

        $contactDetail = $this->createContact($this->name, $company->id);
        $company->contact_id = $contactDetail->id;
        $company->save();
        
        $contactVendor = Contact::forceCreate(['company_id' => $company->id,
            'contact_type_id' => $typeVendor->id,
            'name' => Lang::get('setup.GenericVendor'),
            'license_no' => '123456']);
    
        Contact::forceCreate(['company_id' => $company->id,
            'contact_type_id' => $typeDriver->id,
            'name' => Lang::get('setup.GenericDriver'),
            'license_no' => '123456']);

        $modelCar = Model::forceCreate(['model_type_id' => $typeCar->id,
            'vendor_id' => $contactVendor->id,
            'name' => Lang::get('setup.GenericCar'),
            'company_id' => $company->id]);
    
        Model::forceCreate(['model_type_id' => $typeTruck->id,
            'vendor_id' => $contactVendor->id,
            'name' => Lang::get('setup.GenericTruck'),
            'company_id' => $company->id]);
    
        Model::forceCreate(['model_type_id' => $typeTire->id,
            'name' => Lang::get('setup.GenericTire'),
            'company_id' => $company->id]);
    
        Model::forceCreate(['model_type_id' => $typeSensor->id,
            'name' => Lang::get('setup.GenericSensor'),
            'company_id' => $company->id]);

        Vehicle::forceCreate(['model_vehicle_id' => $modelCar->id,
            'number' => Lang::get('setup.VehiclePlate'),
            'initial_miliage' => 123,
            'actual_miliage' => 123,
            'cost' => 50000,
            'description' => Lang::get('setup.GenericVehicle'),
            'company_id' => $company->id]);
    }
    
    private function setUserProperties($company)
    {
        $this->company_id = $company->id;
        $this->save();
        $this->syncRoles('administrator');
    }
    
    public function createContact($name, $company_id)
    {
        $typeDetail = Type::where('entity_key', 'contact')
                            ->where(function ($query) {
                                $query->where('name', Lang::get('setup.detail'))
                                    ->orWhere('name', 'detail');
                            })
                            ->where('company_id', $company_id)
                            ->first();
        
        $contactUser = Contact::forceCreate(['company_id' => $company_id,
            'contact_type_id' => $typeDetail->id,
            'name' => $name]);
        $contactUser->save();
        $this->contact_id = $contactUser->id;
        $this->save();
        return $contactUser;
    }
    
    public function checkCompanyRelationships()
    {
        return [];
    }
    
    public static function boot()
    {
        parent::boot();
        User::creating(function ($user) {
            $user->company_id = ( $user->company_id ?: Auth::user()['company_id'] );
        });
    }
}
