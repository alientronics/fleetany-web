<?php

class ModelTireTest extends TestCase
{
    public function testCreate()
    {
        $this->visit('/modeltire/create')
            ->type('Nome Pneu Teste', 'name')
            ->type('10', 'pressure_ideal')
            ->type('12', 'pressure_max')
            ->type('8', 'pressure_min')
            ->type('5', 'mileage')
            ->type('50,1', 'temp_ideal')
            ->type('60,2', 'temp_max')
            ->type('40,3', 'temp_min')
            ->type('20,4', 'start_diameter')
            ->type('30,5', 'start_depth')
            ->type('40', 'type_land')
            ->press('Enviar')
            ->seePageIs('/modeltire')
        ;
        
        $this->seeInDatabase('model_tires', 
                ['name' => 'Nome Pneu Teste', 
                 'pressure_ideal' => '10', 
                 'pressure_max' => '12', 
                 'pressure_min' => '8', 
                 'mileage' => '5', 
                 'temp_ideal' => '50,1', 
                 'temp_max' => '60,2', 
                 'temp_min' => '40,3', 
                 'start_diameter' => '20,4', 
                 'start_depth' => '30,5', 
                 'type_land' => '40'
                ]);
    }
    
    public function testUpdate()
    {
        $this->visit('/modeltire')
            ->click('Nome Pneu Teste')
            ->type('Nome Pneu Editado', 'name')
            ->type('11', 'pressure_ideal')
            ->type('13', 'pressure_max')
            ->type('9', 'pressure_min')
            ->type('5', 'mileage')
            ->type('51,2', 'temp_ideal')
            ->type('61,3', 'temp_max')
            ->type('41,4', 'temp_min')
            ->type('21,5', 'start_diameter')
            ->type('31,6', 'start_depth')
            ->type('41', 'type_land')
            ->press('Enviar')
            ->seePageIs('/modeltire')
        ;
        
        $this->seeInDatabase('model_tires',
            ['name' => 'Nome Pneu Editado',
                'pressure_ideal' => '11',
                'pressure_max' => '13',
                'pressure_min' => '9',
                'mileage' => '5',
                'temp_ideal' => '51,2',
                'temp_max' => '61,3',
                'temp_min' => '41,4',
                'start_diameter' => '21,5',
                'start_depth' => '31,6',
                'type_land' => '41'
            ]);
    }
    
    public function testDelete()
    {
        $this->visit('/modeltire')
            ->press('Excluir');
        
        $this->notSeeInDatabase('model_tires',
            ['name' => 'Nome Pneu Editado',
                'pressure_ideal' => '11',
                'pressure_max' => '13',
                'pressure_min' => '9',
                'mileage' => '5',
                'temp_ideal' => '51,2',
                'temp_max' => '61,3',
                'temp_min' => '41,4',
                'start_diameter' => '21,5',
                'start_depth' => '31,6',
                'type_land' => '41'
            ]);
    }
}
