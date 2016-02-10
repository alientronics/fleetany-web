<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class ModelMonitorTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testModelMonitor()
    {
        $this->be(User::find(1));

        $this->visit('/modelmonitor/create')
            ->type('Nome Monitor Teste', 'name')
            ->type('1', 'version')
            ->press('Enviar')
            ->seePageIs('/modelmonitor')
        ;
        
        $this->seeInDatabase('model_monitors', ['name' => 'Nome Monitor Teste', 'version' => '1']);
        
        
        $this->click('Nome Monitor Teste')
            ->type('Nome Monitor Editado', 'name')
            ->type(2, 'version')
            ->press('Enviar')
        ;

        $this->seeInDatabase('model_monitors', ['name' => 'Nome Monitor Editado', 'version' => '2']);
    }
}
