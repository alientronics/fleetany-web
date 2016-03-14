<?php

use App\Entities\Vehicle;
class VehiclePermissionTest extends TestCase
{
    public function testViewAdmin()
    {
        $this->visit('/')->see('vehicle">Ve');
    
        $this->visit('/vehicle')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testViewExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
    
        $this->visit('/')->see('vehicle">Ve', true);
    
        $this->visit('/vehicle')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testCreateAdmin()
    {
        $this->visit('/vehicle')->see('Novo');
        
        $this->visit('/vehicle/create');
    
        $this->type('IOP-1234', 'number')
            ->type('123', 'initial_miliage')
            ->type('456', 'actual_miliage')
            ->type('90000', 'cost')
            ->type('Descricao', 'description')
            ->press('Enviar')
            ->seePageIs('/vehicle')
        ;
    
        $this->seeInDatabase('vehicles', 
                [
                    'number' => 'IOP-1234',
                    'initial_miliage' => '123',
                    'actual_miliage' => '456',
                    'cost' => '90000',
                    'description' => 'Descricao',
                ]);
    }
    
    public function testCreateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/vehicle')->see('Novo', true);
    
        $this->visit('/vehicle/create')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testUpdateAdmin()
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
    
        $this->seeInDatabase('vehicles', 
                [
                    'number' => 'IOP-1235',
                    'initial_miliage' => '125',
                    'actual_miliage' => '455',
                    'cost' => '90005',
                    'description' => 'Descricao2',
                ]);
    }
    
    public function testUpdateExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/vehicle')
            ->see('Editar', true)
        ;
        
        $this->visit('/vehicle/'.Vehicle::all()->last()['id'].'/edit')
            ->see('de acesso para esta p')
        ;
    }
    
    public function testDeleteAdmin()
    {
        $this->seeInDatabase('vehicles', ['id' => 1]);
        $this->visit('/vehicle');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $crawler = $this->click($idOption);
        $this->notSeeInDatabase('vehicles', ['id' => 1]);
    }
    
    public function testDeleteExecutive()
    {
        $user = $this->createExecutive();
        $this->actingAs($user);
        
        $this->visit('/vehicle')
            ->see('Excluir', true)
        ;
    }
}
