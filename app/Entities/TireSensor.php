<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TireSensor extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'tire_sensor';
    protected $fillable = ['part_id', 'temperature', 'pressure',
                            'latitude', 'longitude', 'number'
                          ];

    public function part()
    {
        return $this->belongsTo(\App\Entities\Part::class, 'part_id', 'id');
    }
}
