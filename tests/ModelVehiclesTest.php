<?php

use App\User;

class ModelVehicleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testModelVehicle()
    {
        $this->be(User::find(1));

        $this->visit('/typevehicle/create')
            ->type('Nome Tipo Veiculo Teste', 'name')
            ->press('Enviar')
            ->seePageIs('/typevehicle')
        ;
        
        $this->seeInDatabase('type_vehicles', ['name' => 'Nome Tipo Veiculo Teste']);
        
        $this->click('Nome Tipo Veiculo Teste')
            ->type('Nome Tipo Veiculo Editado', 'name')
            ->press('Enviar')
        ;
            
        $this->seeInDatabase('type_vehicles', ['name' => 'Nome Tipo Veiculo Editado']);
        
        $this->visit('/modelvehicle/create');
        
        $idOption = $this->crawler->filterXPath("//select[@id='type_vehicle_id']/option[1]")->attr('value');

        $this->type('Nome Veiculo Teste', 'name')
            ->select($idOption, 'type_vehicle_id')
            ->type('2015', 'year')
            ->type('4', 'number_of_wheels')
            ->press('Enviar')
            ->seePageIs('/modelvehicle')
        ;
        
        $this->seeInDatabase('model_vehicles', 
                ['name' => 'Nome Veiculo Teste', 
                    'type_vehicle_id' => $idOption, 
                    'year' => '2015', 
                    'number_of_wheels' => '4'
                ]);
        
        $this->click('Nome Veiculo Teste')
            ->type('Nome Veiculo Editado', 'name')
            ->type('2016', 'year')
            ->type('6', 'number_of_wheels')
            ->press('Enviar')
        ;

        $this->seeInDatabase('model_vehicles', 
                ['name' => 'Nome Veiculo Editado', 
                    'type_vehicle_id' => $idOption, 
                    'year' => '2016', 
                    'number_of_wheels' => '6'
                ]);
        

        $this->visit('/modelvehicle')->press('Excluir');
        
        $this->notSeeInDatabase('model_vehicles', 
                ['name' => 'Nome Veiculo Editado', 
                    'type_vehicle_id' => $idOption, 
                    'year' => '2016', 
                    'number_of_wheels' => '6'
                ]);

        $this->visit('/typevehicle')->press('Excluir');
        
        $this->notSeeInDatabase('type_vehicles', ['name' => 'Nome Tipo Veiculo Editado']);
        
    }
}
