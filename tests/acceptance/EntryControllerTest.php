<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Entry;

class EntryControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/')->see('mdl-navigation__link" href="'.$this->baseUrl.'/entry">');
    
        $this->visit('/entry')
            ->see('<i class="material-icons">filter_list</i>')
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/entry')->see('<a href="'.$this->baseUrl.'/entry/create');
        
        $this->visit('/entry/create');
    
        $form = $this->getForm();
        $form['parts'][0]->tick();
        $form['datetime_ini']->setValue('2016-01-01 15:15:15');
        $form['datetime_end']->setValue('2016-01-02 15:15:15');
        $form['entry_number']->setValue('123');
        $form['cost']->setValue('90000.00');
        $form['description']->setValue('Descricao');

        $partId = $form['parts'][0]->getValue();
        
        $this->makeRequestUsingForm($form)
            ->seePageIs('/entry')
        ;
        
        $this->seeInDatabase(
            'entries',
            [
                    'datetime_ini' => '2016-01-01 15:15:15',
                    'datetime_end' => '2016-01-02 15:15:15',
                    'entry_number' => '123',
                    'cost' => '90000',
                    'description' => 'Descricao',
            ]
        );
        
        $this->seeInDatabase(
            'part_entry',
            [
                    'entry_id' => Entry::all()->last()['id'],
                    'part_id' => $partId
            ]
        );
    }
    
    public function testUpdate()
    {
        $this->visit('/entry/'.Entry::all()->last()['id'].'/edit');
        $form = $this->getForm();
        $form['parts'][1]->tick();
        $partId2 = $form['parts'][1]->getValue();
        $form['datetime_ini']->setValue('2016-05-01 15:15:15');
        $form['datetime_end']->setValue('2016-05-02 15:15:15');
        $form['entry_number']->setValue('125');
        $form['cost']->setValue('90005.00');
        $form['description']->setValue('Descricao2');
        
        $this->makeRequestUsingForm($form)
            ->seePageIs('/entry')
        ;
        
        $this->seeInDatabase(
            'entries',
            [
                    'datetime_ini' => '2016-05-01 15:15:15',
                    'datetime_end' => '2016-05-02 15:15:15',
                    'entry_number' => '125',
                    'cost' => '90005',
                    'description' => 'Descricao2',
            ]
        );

        $this->seeInDatabase(
            'part_entry',
            [
                    'entry_id' => Entry::all()->last()['id'],
                    'part_id' => $partId2
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
    
    public function testErrors()
    {
        $this->visit('/entry/create')
            ->press('Enviar')
            ->seePageIs('/entry/create')
            ->see('de um valor para o campo datetime ini.</span>')
            ->see('<span class="mdl-textfield__error">O campo cost dever')
        ;
    }
    
    public function testFilters()
    {
        $this->visit('/entry')
            ->type('Generic Car', 'vehicle')
            ->type('service', 'entry_type')
            ->type('01/01/2016 00:00:00', 'datetime_ini')
            ->type('321,00', 'cost')
            ->press('Buscar')
            ->see('Generic Car</div>')
            ->see('service</div>')
            ->see('01/01/2016 00:00:00</div>')
            ->see('321,00</div>')
        ;
    }
    
    public function testSort()
    {
        $this->visit('/entry?id=&vehicle=&entry-type=&datetime-ini=&cost=&sort=id-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/entry?id=&vehicle=&entry-type=&datetime-ini=&cost=&sort=id-asc')
            ->see('mode_edit</i>');
        
        $this->visit('/entry?id=&vehicle=&entry-type=&datetime-ini=&cost=&sort=vehicle-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/entry?id=&vehicle=&entry-type=&datetime-ini=&cost=&sort=vehicle-asc')
            ->see('mode_edit</i>');

        $this->visit('/entry?id=&vehicle=&entry-type=&datetime-ini=&cost=&sort=entry-type-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/entry?id=&vehicle=&entry-type=&datetime-ini=&cost=&sort=entry-type-asc')
            ->see('mode_edit</i>');
            
        $this->visit('/entry?id=&vehicle=&entry-type=&datetime-ini=&cost=&sort=datetime-ini-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/entry?id=&vehicle=&entry-type=&datetime-ini=&cost=&sort=datetime-ini-asc')
            ->see('mode_edit</i>');
            
        $this->visit('/entry?id=&vehicle=&entry-type=&datetime-ini=&cost=&sort=cost-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/entry?id=&vehicle=&entry-type=&datetime-ini=&cost=&sort=cost-asc')
            ->see('mode_edit</i>');
        
    }
}
