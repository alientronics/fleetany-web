<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Part;
use App\Entities\Type;

class PartControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/')->see('mdl-navigation__link" href="'.$this->baseUrl.'/part">');
    
        $this->visit('/part')
            ->see('<i class="material-icons">filter_list</i>')
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/part')->see('<a href="'.$this->baseUrl.'/part/create');
        
        $this->visit('/part/create');
    
        $this->type('125,00', 'cost')
            ->type('Name', 'name')
            ->type('123456', 'number')
            ->type('450', 'miliage')
            ->type('3', 'position')
            ->type('1000', 'lifecycle')
            ->press('Enviar')
            ->seePageIs('/part')
        ;
    
        $this->seeInDatabase(
            'parts',
            [
                    'cost' => 125.00,
                    'name' => 'Name',
                    'number' => '123456',
                    'miliage' => 450,
                    'position' => '3',
                    'lifecycle' => 1000
            ]
        );
    }

    public function testUpdate()
    {
        $this->visit('/part/'.Part::all()->last()['id'].'/edit');
    
        $this->type('125,60', 'cost')
            ->type('Name2', 'name')
            ->type('123457', 'number')
            ->type('456', 'miliage')
            ->type('4', 'position')
            ->type('1005', 'lifecycle')
            ->press('Enviar')
            ->seePageIs('/part')
        ;
    
        $this->seeInDatabase(
            'parts',
            [
                    'cost' => 125.60,
                    'name' => 'Name2',
                    'number' => '123457',
                    'miliage' => 456,
                    'position' => '4',
                    'lifecycle' => 1005
            ]
        );
    }
    
    public function testDelete()
    {
        $idDelete = Part::all()->last()['id'];
        $this->seeInDatabase('parts', ['id' => $idDelete]);
        $this->visit('/part/destroy/'.$idDelete);
        $this->seeIsSoftDeletedInDatabase('parts', ['id' => $idDelete]);
    }
    
    public function testErrors()
    {
        $this->visit('/part/create')
            ->press('Enviar')
            ->seePageIs('/part/create')
            ->see('de um valor para o campo number.</span>')
        ;
    }
    
    public function testFilters()
    {
        $this->visit('/part')
            ->type('Generic Car', 'vehicle')
            ->type('tire', 'part_type')
            ->type('200,00', 'cost')
            ->press('Buscar')
            ->see('Generic Car</div>')
            ->see('tire</div>')
            ->see('200,00</div>')
        ;
    }
    
    public function testSort()
    {
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=id-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=id-asc')
            ->see('mode_edit</i>');
        
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=name-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=name-asc')
            ->see('mode_edit</i>');
        
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=number-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=number-asc')
            ->see('mode_edit</i>');
        
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=position-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=position-asc')
            ->see('mode_edit</i>');

        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=vehicle-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=vehicle-asc')
            ->see('mode_edit</i>');

        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=part-type-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=part-type-asc')
            ->see('mode_edit</i>');

        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=cost-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/part?id=&name=&number=&position=&vehicle=&part-type=&cost=&sort=cost-asc')
            ->see('mode_edit</i>');
    }
}
