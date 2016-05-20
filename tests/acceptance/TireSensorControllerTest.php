<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Part;
use App\Entities\Type;

class TireSensorControllerTest extends AcceptanceTestCase
{
    public function testFilters()
    {
        $idPart = Part::select('parts.id')
            ->join('types', 'types.id', '=', 'parts.part_type_id')
            ->where('types.entity_key', 'part')
            ->where('types.name', 'sensor')
            ->first()['id'];
        
        $tireSensor = factory(\App\Entities\TireSensor::class)->create([
            'part_id' => $idPart,
        ]);
        
        $this->visit('/part/'.$idPart.'/edit?id=&temperature=1&pressure=1&battery=1&latitude=
                        &longitude=&number=1&sort=temperature-asc')
            ->see('mdl-cell--1-col mdl-data-table__cell--non-numeric">');
    }
    
    public function testSort()
    {
        
        $idPart = Part::select('parts.id')
            ->join('types', 'types.id', '=', 'parts.part_type_id')
            ->where('types.entity_key', 'part')
            ->where('types.name', 'sensor')
            ->first()['id'];
        
        $tireSensor = factory(\App\Entities\TireSensor::class)->create([
            'part_id' => $idPart,
        ]);
        
        $url = '/part/'.$idPart.'/edit?id=&temperature=&pressure=&battery=&latitude=&longitude=&number=';
        
        $this->visit($url.'&sort=temperature-asc')
            ->see('mdl-cell--1-col mdl-data-table__cell--non-numeric">');
        
        $this->visit($url.'&sort=id-asc')
            ->see('mdl-cell--1-col mdl-data-table__cell--non-numeric">');

        $this->visit($url.'&sort=vehicle-desc')
            ->see('mdl-cell--1-col mdl-data-table__cell--non-numeric">');
            
        $this->visit($url.'&sort=vehicle-asc')
            ->see('mdl-cell--1-col mdl-data-table__cell--non-numeric">');

        $this->visit($url.'&sort=part-type-desc')
            ->see('mdl-cell--1-col mdl-data-table__cell--non-numeric">');
            
        $this->visit($url.'&sort=part-type-asc')
            ->see('mdl-cell--1-col mdl-data-table__cell--non-numeric">');

        $this->visit($url.'&sort=cost-desc')
            ->see('mdl-cell--1-col mdl-data-table__cell--non-numeric">');
            
        $this->visit($url.'&sort=cost-asc')
            ->see('mdl-cell--1-col mdl-data-table__cell--non-numeric">');
            
    }
}
