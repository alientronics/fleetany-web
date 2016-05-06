<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartHistory extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'part_history';
    protected $fillable = ['vehicle_id', 'part_id', 'position'];

    
    public function vehicle()
    {
        return $this->belongsTo(\App\Entities\Vehicle::class, 'vehicle_id', 'id');
    }

    public function part()
    {
        return $this->belongsTo(\App\Entities\Part::class, 'part_id', 'id');
    }
}
