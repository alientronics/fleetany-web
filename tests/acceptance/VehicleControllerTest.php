<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Vehicle;

class VehicleControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/')->see('mdl-navigation__link" href="'.$this->baseUrl.'/vehicle">');
    
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

        $entry = factory(\App\Entities\Entry::class)->create([
            'vehicle_id' => $idDelete,
        ]);
        
        $this->seeInDatabase('vehicles', ['id' => $idDelete]);
        $this->visit('/vehicle/destroy/'.$idDelete)
            ->seePageIs('/vehicle')
            ->see('Este registro possui refer');
        $this->seeIsNotSoftDeletedInDatabase('vehicles', ['id' => $idDelete]);
        
        $vehicle = Vehicle::find($idDelete);
        $vehicle->entries()->delete();
        $vehicle->trips()->delete();
        
        $this->seeInDatabase('vehicles', ['id' => $idDelete]);
        $this->visit('/vehicle/destroy/'.$idDelete);
        $this->seeIsSoftDeletedInDatabase('vehicles', ['id' => $idDelete]);
    }
    
    public function testErrors()
    {
        $this->visit('/vehicle/create')
            ->press('Enviar')
            ->seePageIs('/vehicle/create')
            ->see('de um valor para o campo cost.</span>')
        ;
    }
    
    public function testFilters()
    {
        $this->visit('/vehicle')
            ->type('Generic Car', 'model_vehicle')
            ->type('IOP-1234', 'number')
            ->type('50000', 'cost')
            ->press('Buscar')
            ->see('Generic Car</div>')
            ->see('IOP-1234</div>')
        ;
    }
    
    public function testSort()
    {
        $this->visit('/vehicle?id=&model-vehicle=&number=&cost=&sort=id-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/vehicle?id=&model-vehicle=&number=&cost=&sort=id-asc')
            ->see('mode_edit</i>');
        
        $this->visit('/vehicle?id=&model-vehicle=&number=&cost=&sort=model-vehicle-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/vehicle?id=&model-vehicle=&number=&cost=&sort=model-vehicle-asc')
            ->see('mode_edit</i>');
        
        $this->visit('/vehicle?id=&model-vehicle=&number=&cost=&sort=number-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/vehicle?id=&model-vehicle=&number=&cost=&sort=number-asc')
            ->see('mode_edit</i>');
        
        $this->visit('/vehicle?id=&model-vehicle=&number=&cost=&sort=cost-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/vehicle?id=&model-vehicle=&number=&cost=&sort=cost-asc')
            ->see('mode_edit</i>');
        
    }
}
