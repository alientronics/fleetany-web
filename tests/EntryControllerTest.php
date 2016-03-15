<?php

use App\Entities\Entry;

class EntryControllerTest extends TestCase
{
    public function testView()
    {
        $this->visit('/')->see('entry">Entrada');
    
        $this->visit('/entry')
            ->see('de acesso para esta p', true)
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/entry')->see('Novo');
        
        $this->visit('/entry/create');
    
        $this->type('2016-01-01', 'datetime_ini')
            ->type('2016-01-02', 'datetime_end')
            ->type('123', 'entry_number')
            ->type('90000', 'cost')
            ->type('Descricao', 'description')
            ->press('Enviar')
            ->seePageIs('/entry')
        ;
    
        $this->seeInDatabase('entries', 
                [
                    'datetime_ini' => '2016-01-01',
                    'datetime_end' => '2016-01-02',
                    'entry_number' => '123',
                    'cost' => '90000',
                    'description' => 'Descricao',
                ]);
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
    
        $this->seeInDatabase('entries', 
                [
                    'datetime_ini' => '2016-05-01',
                    'datetime_end' => '2016-05-02',
                    'entry_number' => '125',
                    'cost' => '90005',
                    'description' => 'Descricao2',
                ]);
    }
    
    public function testDelete()
    {
        $this->seeInDatabase('entries', ['id' => 1]);
        $this->visit('/entry');
        $idOption = $this->crawler->filterXPath("//a[@name='Excluir']")->eq(0)->attr('name');
        $crawler = $this->click($idOption);
        $this->seeIsSoftDeletedInDatabase('entries', ['id' => 1]);
    }
}
