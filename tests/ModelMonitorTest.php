<?php

use App\Entities\ModelMonitor;
class ModelMonitorTest extends TestCase
{
    public function testCreate()
    {
        $this->visit('/modelmonitor/create')
            ->type('Nome Monitor Teste', 'name')
            ->type('1', 'version')
            ->press('Enviar')
            ->seePageIs('/modelmonitor')
        ;
        
        $this->seeInDatabase('model_monitors', ['name' => 'Nome Monitor Teste', 'version' => '1']);
    }
    
    public function testUpdate()
    {
        $this->visit('/modelmonitor/'.ModelMonitor::all()->last()['id'].'/edit')
            ->type('Nome Monitor Editado', 'name')
            ->type(2, 'version')
            ->press('Enviar')
        ;
        
        $this->seeInDatabase('model_monitors', ['name' => 'Nome Monitor Editado', 'version' => '2']);
    }
    
    public function testDelete()
    {
        $this->visit('/modelmonitor')
            ->press('Excluir');
    
        $this->notSeeInDatabase('model_monitors', ['name' => 'Nome Monitor Editado', 'version' => '2']);
    }

}
