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
        $this->company_id = $company->id;
        $this->save();
        
        $typeRepair = Type::forceCreate(['entity_key' => 'entry',
            'name' => 'repair',
            'company_id' => $company->id]);
        $typeRepair->save();
        
        $typeService = Type::forceCreate(['entity_key' => 'entry',
            'name' => 'service',
            'company_id' => $company->id]);
        $typeService->save();
        
        $typeCar = Type::forceCreate(['entity_key' => 'vehicle',
            'name' => 'car',
            'company_id' => $company->id]);
        $typeCar->save();
    
        $typeTruck = Type::forceCreate(['entity_key' => 'vehicle',
            'name' => 'truck',
            'company_id' => $company->id]);
        $typeTruck->save();
    
        $typeVendor = Type::forceCreate(['entity_key' => 'contact',
            'name' => 'vendor',
            'company_id' => $company->id]);
        $typeVendor->save();
    
        $typeDriver = Type::forceCreate(['entity_key' => 'contact',
            'name' => 'driver',
            'company_id' => $company->id]);
        $typeDriver->save();
    
        $typeContactDetail = Type::forceCreate(['entity_key' => 'contact',
            'name' => 'detail',
            'company_id' => $company->id]);
        $typeContactDetail->save();
    
        $typeTour = Type::forceCreate(['entity_key' => 'trip',
            'name' => 'tour',
            'company_id' => $company->id]);
        $typeTour->save();
    
        $typeDelivery = Type::forceCreate(['entity_key' => 'trip',
            'name' => 'delivery',
            'company_id' => $company->id]);
        $typeDelivery->save();

        $contactDetail = $this->createContact($this->name, $company->id);
        $company->contact_id = $contactDetail->id;
        $company->save();
        
        $contactVendor = Contact::forceCreate(['company_id' => $company->id,
            'contact_type_id' => $typeVendor->id,
            'name' => 'Generic Vendor',
            'license_no' => '123456']);
        $contactVendor->save();
    
        $contactDriver = Contact::forceCreate(['company_id' => $company->id,
            'contact_type_id' => $typeDriver->id,
            'name' => 'Generic Driver',
            'license_no' => '123456']);
        $contactDriver->save();

        $modelCar = Model::forceCreate(['model_type_id' => $typeCar->id,
            'vendor_id' => $contactVendor->id,
            'name' => 'Generic Car',
            'company_id' => $company->id]);
        $modelCar->save();
    
        $modelTruck = Model::forceCreate(['model_type_id' => $typeTruck->id,
            'vendor_id' => $contactVendor->id,
            'name' => 'Generic Truck',
            'company_id' => $company->id]);
        $modelTruck->save();

        $vehicle = Vehicle::forceCreate(['model_vehicle_id' => $modelCar->id,
            'number' => 'IOP-1234',
            'initial_miliage' => 123,
            'actual_miliage' => 123,
            'cost' => 50000,
            'description' => 'Generic Vehicle',
            'company_id' => $company->id]);
        $vehicle->save();
        
        $this->syncRoles('administrator');
    }
    
    public function createContact($name, $company_id)
    {
        $typeDetail = Type::where('entity_key', 'contact')
                            ->where('name', 'detail')
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
