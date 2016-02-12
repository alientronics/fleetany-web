<?php

use App\User;

class TypeVehicleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testTypeVehicle()
    {
        $this->be(User::find(1));

        $this->visit('/typevehicle/create')
            ->type('Nome Tipo Veiculo Teste', 'name')
            ->press('Enviar')
            ->seePageIs('/typevehicle')
        ;
        
        $this->seeInDatabase('type_vehicles', ['id' => 1, 'name' => 'Nome Tipo Veiculo Teste']);
        
        $this->click('Nome Tipo Veiculo Teste')
            ->type('Nome Tipo Veiculo Editado', 'name')
            ->press('Enviar')
        ;

        $this->seeInDatabase('type_vehicles', ['id' => 1, 'name' => 'Nome Tipo Veiculo Editado']);

        $this->press('Excluir');

        $this->notSeeInDatabase('type_vehicles', ['id' => 1, 'name' => 'Nome Tipo Veiculo Editado']);
    }
}
