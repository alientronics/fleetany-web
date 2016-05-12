<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Entry extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'entries';
    protected $fillable = ['entry_type_id', 'vendor_id', 'vehicle_id', 'datetime_ini',
                            'datetime_end', 'entry_number', 'cost', 'description'];


    public function company()
    {
        return $this->belongsTo(\App\Entities\Company::class, 'company_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(\App\Entities\Type::class, 'entry_type_id', 'id');
    }

    public function contact()
    {
        return $this->belongsTo(\App\Entities\Contact::class, 'vendor_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(\App\Entities\Vehicle::class, 'vehicle_id', 'id');
    }
    
    public function partsEntries()
    {
        return $this->hasMany(\App\Entities\PartEntry::class, 'entry_id', 'id');
    }
    
    public function checkCompanyRelationships()
    {
        return [
            "entry_type_id" => "Type",
            "vendor_id" => "Contact",
            "vehicle_id" => "Vehicle"
        ];
    }
    
    public function updateEntryParts($idEntry, $parts)
    {
        PartEntry::where('entry_id', $idEntry)->delete();
        
        if (!empty($parts)) {
            foreach ($parts as $part) {
                PartEntry::create([
                    "part_id" => $part,
                    "entry_id" => $idEntry
                ]);
            }
        }
    }
    
    protected static function boot()
    {
        parent::boot();
        Entry::creating(function ($entry) {
            $entry->company_id = ( $entry->company_id ?: Auth::user()['company_id'] );
        });
    }
}
