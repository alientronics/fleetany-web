<?php

namespace Tests\Acceptance;

use Tests\TestCase;
use App\Entities\Trip;

class TripControllerTest extends TestCase
{
    public function testView()
    {
        $this->visit('/')->see('trip">Viagens');
    
        $this->visit('/trip')
        ->see('de acesso para esta p', true)
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/trip')->see('Novo');
        
        $this->visit('/trip/create');
    
        $this->type('2016-01-01', 'pickup_date')
            ->type('2016-01-02', 'deliver_date')
            ->type('1200 First Av', 'pickup_place')
            ->type('345 63th St', 'deliver_place')
            ->type('320', 'begin_mileage')
            ->type('450', 'end_mileage')
            ->type('130', 'total_mileage')
            ->type('13.6', 'fuel_cost')
            ->type('5', 'fuel_amount')
            ->type('Descricao', 'description')
            ->press('Enviar')
            ->seePageIs('/trip')
        ;
    
        $this->seeInDatabase(
            'trips',
            [
                    'pickup_date' => '2016-01-01',
                    'deliver_date' => '2016-01-02',
                    'pickup_place' => '1200 First Av',
                    'deliver_place' => '345 63th St',
                    'begin_mileage' => 320,
                    'end_mileage' => 450,
                    'total_mileage' => 130,
                    'fuel_cost' => 13.6,
                    'fuel_amount' => 5,
                    'description' => 'Descricao',
            ]
        );
    }

    public function testUpdate()
    {
        $this->visit('/trip/'.Trip::all()->last()['id'].'/edit');
    
        $this->type('2016-02-01', 'pickup_date')
        ->type('2016-02-02', 'deliver_date')
        ->type('1220 First Av', 'pickup_place')
        ->type('342 63th St', 'deliver_place')
        ->type('322', 'begin_mileage')
        ->type('452', 'end_mileage')
        ->type('132', 'total_mileage')
        ->type('13.2', 'fuel_cost')
        ->type('2', 'fuel_amount')
        ->type('Descricao2', 'description')
        ->press('Enviar')
        ->seePageIs('/trip')
        ;
    
        $this->seeInDatabase(
            'trips',
            [
                'pickup_date' => '2016-02-01',
                'deliver_date' => '2016-02-02',
                'pickup_place' => '1220 First Av',
                'deliver_place' => '342 63th St',
                'begin_mileage' => 322,
                'end_mileage' => 452,
                'total_mileage' => 132,
                'fuel_cost' => 13.2,
                'fuel_amount' => 2,
                'description' => 'Descricao2',
            ]
        );
    }
    
    public function testDelete()
    {
        $this->seeInDatabase('trips', ['id' => 1]);
        $this->visit('/trip');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $this->click($idOption);
        $this->seeIsSoftDeletedInDatabase('trips', ['id' => 1]);
    }
}
