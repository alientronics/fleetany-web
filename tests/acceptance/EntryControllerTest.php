<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Entry;

class EntryControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/')->see('<a class="mdl-navigation__link" href="'.$this->baseUrl.'/entry">');
    
        $this->visit('/entry')
            ->see('<i class="material-icons">filter_list</i>')
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/entry')->see('<a href="'.$this->baseUrl.'/entry/create');
        
        $this->visit('/entry/create');
    
        $this->type('2016-01-01', 'datetime_ini')
            ->type('2016-01-02', 'datetime_end')
            ->type('123', 'entry_number')
            ->type('90000', 'cost')
            ->type('Descricao', 'description')
            ->press('Enviar')
            ->seePageIs('/entry')
        ;
    
        $this->seeInDatabase(
            'entries',
            [
                    'datetime_ini' => '2016-01-01',
                    'datetime_end' => '2016-01-02',
                    'entry_number' => '123',
                    'cost' => '90000',
                    'description' => 'Descricao',
            ]
        );
    }
    
    public function testUpdate()
    {
        $this->visit('/entry/'.Entry::all()->last()['id'].'/edit');
        
        $this->type('2016-05-01', 'datetime_ini')
            ->type('2016-05-02', 'datetime_end')
            ->type('125', 'entry_number')
            ->type('90005', 'cost')
            ->type('Descricao2', 'description')
            ->press('Enviar')
            ->seePageIs('/entry')
        ;
    
        $this->seeInDatabase(
            'entries',
            [
                    'datetime_ini' => '2016-05-01',
                    'datetime_end' => '2016-05-02',
                    'entry_number' => '125',
                    'cost' => '90005',
                    'description' => 'Descricao2',
            ]
        );
    }
    
    public function testDelete()
    {
        $idDelete = Entry::all()->last()['id'];
        $this->seeInDatabase('entries', ['id' => $idDelete]);
        $this->visit('/entry/destroy/'.$idDelete);
        $this->seeIsSoftDeletedInDatabase('entries', ['id' => $idDelete]);
    }
}
