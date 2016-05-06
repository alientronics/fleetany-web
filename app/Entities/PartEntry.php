<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartEntry extends BaseModel
{

    /**
     * Generated
     */

    use SoftDeletes;
    
    protected $table = 'part_entry';
    protected $fillable = ['entry_id', 'part_id'];

    public function entry()
    {
        return $this->belongsTo(\App\Entities\Entry::class, 'entry_id', 'id');
    }
    
    public function part()
    {
        return $this->belongsTo(\App\Entities\Part::class, 'part_id', 'id');
    }
}
