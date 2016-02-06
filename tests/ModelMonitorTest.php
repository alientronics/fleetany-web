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
    public function testBasicExample()
    {
        $this->be(User::find(1));

        $this->visit('/modelmonitor/create')
            ->type('Nome', 'name')
            ->type('1', 'version')
            ->press('Enviar')
            ->seePageIs('/modelmonitor');
        
        $this->seeInDatabase('model_monitors', ['name' => 'Nome', 'version' => '1']);
    }
}
