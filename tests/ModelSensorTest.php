<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class ModelSensorTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testModelSensor()
    {
        $this->be(User::find(1));

        $this->visit('/modelsensor/create')
            ->type('Nome Sensor Teste', 'name')
            ->type('1', 'version')
            ->press('Enviar')
            ->seePageIs('/modelsensor')
        ;
        
        $this->seeInDatabase('model_sensors', ['name' => 'Nome Sensor Teste', 'version' => '1']);
        
        
        $this->click('Nome Sensor Teste')
            ->type('Nome Sensor Editado', 'name')
            ->type(2, 'version')
            ->press('Enviar')
        ;

        $this->seeInDatabase('model_sensors', ['name' => 'Nome Sensor Editado', 'version' => '2']);
    }
}
