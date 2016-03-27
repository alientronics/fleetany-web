<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Vehicle;

class VehicleControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/vehicle">');
    
        $this->visit('/vehicle')
            ->see('<i class="material-icons">filter_list</i>')
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/vehicle')->see('<a href="'.$this->baseUrl.'/vehicle/create');
        
        $this->visit('/vehicle/create');
    
        $this->type('IOP-1234', 'number')
            ->type('123', 'initial_miliage')
            ->type('456', 'actual_miliage')
            ->type('90000', 'cost')
            ->type('Descricao', 'description')
            ->press('Enviar')
            ->seePageIs('/vehicle')
        ;
    
        $this->seeInDatabase(
            'vehicles',
            [
                    'number' => 'IOP-1234',
                    'initial_miliage' => '123',
                    'actual_miliage' => '456',
                    'cost' => '90000',
                    'description' => 'Descricao',
            ]
        );
    }
    
    public function testUpdate()
    {
        $this->visit('/vehicle/'.Vehicle::all()->last()['id'].'/edit');
        
        $this->type('IOP-1235', 'number')
            ->type('125', 'initial_miliage')
            ->type('455', 'actual_miliage')
            ->type('90005', 'cost')
            ->type('Descricao2', 'description')
            ->press('Enviar')
            ->seePageIs('/vehicle')
        ;
    
        $this->seeInDatabase(
            'vehicles',
            [
                    'number' => 'IOP-1235',
                    'initial_miliage' => '125',
                    'actual_miliage' => '455',
                    'cost' => '90005',
                    'description' => 'Descricao2',
            ]
        );
    }
    
    public function testDelete()
    {
        $idDelete = Vehicle::all()->last()['id'];
        $this->seeInDatabase('vehicles', ['id' => $idDelete]);
        $this->visit('/vehicle/destroy/'.$idDelete);
        $this->seeIsSoftDeletedInDatabase('vehicles', ['id' => $idDelete]);
    }
}
