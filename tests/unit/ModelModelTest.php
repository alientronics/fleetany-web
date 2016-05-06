<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class ModelModelTest extends UnitTestCase
{

    public function testHasCompany()
    {
    
        $company = factory(\App\Entities\Company::class)->create();
        $model = factory(\App\Entities\Model::class)->create([
            'company_id' => $company->id,
        ]);
    
        $this->assertEquals($model->company->name, $company->name);
    }
    
    public function testHasType()
    {
    
        $type = factory(\App\Entities\Type::class)->create();
        $model = factory(\App\Entities\Model::class)->create([
            'model_type_id' => $type->id,
        ]);
    
        $this->assertEquals($model->type->name, $type->name);
    }
    
    public function testHasContact()
    {
    
        $contact = factory(\App\Entities\Contact::class)->create();
        $model = factory(\App\Entities\Model::class)->create([
            'vendor_id' => $contact->id,
        ]);
    
        $this->assertEquals($model->contact->name, $contact->name);
    }

    public function testHasParts()
    {

        $model = factory(\App\Entities\Model::class)->create();

        $part1 = factory(\App\Entities\Part::class)->create([
                'company_id' => $model->id,
            ]);

        $part2 = factory(\App\Entities\Part::class)->create([
                'company_id' => $model->id,
            ]);

        $this->assertEquals(count($model->parts), 2);
        $this->assertTrue($model->parts->contains($part1));
        $this->assertTrue($model->parts->contains($part2));
        
    }

    public function testHasVehicles()
    {

        $model = factory(\App\Entities\Model::class)->create();

        $vehicle1 = factory(\App\Entities\Vehicle::class)->create([
                'model_vehicle_id' => $model->id,
            ]);

        $vehicle2 = factory(\App\Entities\Vehicle::class)->create([
                'model_vehicle_id' => $model->id,
            ]);

        $this->assertEquals(count($model->vehicles), 2);
        $this->assertTrue($model->vehicles->contains($vehicle1));
        $this->assertTrue($model->vehicles->contains($vehicle2));
    }
}
