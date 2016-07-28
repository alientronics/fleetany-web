<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Model;

class ModelControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/')->see('mdl-navigation__link" href="'.$this->baseUrl.'/model">');
    
        $this->visit('/model')
            ->see('<i class="material-icons">filter_list</i>')
        ;
    }
    
    public function testCreate()
    {
        $this->visit('/model')->see('<a href="'.$this->baseUrl.'/model/create');
        
        $this->visit('/model/create');
    
        $this->type('Nome Modelo', 'name')
            ->press('Enviar')
            ->seePageIs('/model')
        ;
    
        $this->seeInDatabase('models', ['name' => 'Nome Modelo']);
    }
    
    public function testUpdate()
    {
        $this->visit('/model/'.Model::all()->last()['id'].'/edit');
        
        $this->type('Nome Modelo Editado', 'name')
            ->press('Enviar')
            ->seePageIs('/model')
        ;
        
        $this->seeInDatabase('models', ['name' => 'Nome Modelo Editado']);
    }
    
    public function testDelete()
    {
        $idDelete = Model::all()->last()['id'];

        factory(\App\Entities\Vehicle::class)->create([
            'model_vehicle_id' => $idDelete,
        ]);
        
        $this->seeInDatabase('models', ['id' => $idDelete]);
        $this->visit('/model/destroy/'.$idDelete)
            ->seePageIs('/model')
            ->see('Este registro possui refer');
        $this->seeIsNotSoftDeletedInDatabase('models', ['id' => $idDelete]);
        
        $model = Model::find($idDelete);
        $model->vehicles()->delete();
        $this->seeInDatabase('models', ['id' => $idDelete]);
        $this->visit('/model/destroy/'.$idDelete);
        $this->seeIsSoftDeletedInDatabase('models', ['id' => $idDelete]);
    }
    
    public function testErrors()
    {
        $this->visit('/model/create')
            ->press('Enviar')
            ->seePageIs('/model/create')
            ->see('de um valor para o campo nome.</span>')
        ;
    }
    
    public function testFilters()
    {
        $this->visit('/model')
            ->type('car', 'model_type')
            ->type('Vendor Name', 'vendor')
            ->type('Generic Car', 'name')
            ->press('Buscar')
            ->see('car</div>')
            ->see('Vendor Name</div>')
            ->see('Generic Car</div>')
        ;
    }
    
    public function testSort()
    {
        $this->visit('/model?id=&model-type=&vendor=&name=&sort=id-desc')
            ->see('mode_edit</i>');
        
        $this->visit('/model?id=&model-type=&vendor=&name=&sort=id-asc')
            ->see('mode_edit</i>');

        $this->visit('/model?id=&model-type=&vendor=&name=&sort=vendor-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/model?id=&model-type=&vendor=&name=&sort=vendor-asc')
            ->see('mode_edit</i>');

        $this->visit('/model?id=&model-type=&vendor=&name=&sort=model-type-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/model?id=&model-type=&vendor=&name=&sort=model-type-asc')
            ->see('mode_edit</i>');

        $this->visit('/model?id=&model-type=&vendor=&name=&sort=name-desc')
            ->see('mode_edit</i>');
            
        $this->visit('/model?id=&model-type=&vendor=&name=&sort=name-asc')
            ->see('mode_edit</i>');
    }
}
