<?php

namespace Tests\Unit;

use Tests\UnitTestCase;
use Carbon\Carbon;
use App\Repositories\VehicleRepositoryEloquent;
use App\Repositories\EntryRepositoryEloquent;
use App\Repositories\TripRepositoryEloquent;

class DashboardModelTest extends UnitTestCase
{

    protected $company_id;
    
    public function setUp()
    {
        
        parent::setUp();
        
        $company = factory(\App\Entities\Company::class)->create();
        $this->company_id = $company->id;
        
        $user = factory(\App\Entities\User::class)->create([
            'company_id' => $this->company_id,
        ]);
        
        $this->be($user);
    }
    
    public function testVehiclesStatistics()
    {
        $vehicles = [];
        for ($i = 0; $i < 9; $i++) {
            $vehicles[] = factory(\App\Entities\Vehicle::class)->create([
                'company_id' => $this->company_id,
            ]);
        }
        
        // In use tests
        $trips[0] = factory(\App\Entities\Trip::class)->create([
            'company_id' => $this->company_id,
            'vehicle_id' => $vehicles[0]->id,
            'pickup_date' => Carbon::now()->subDays(2)
        ]);
        
        $trips[1] = factory(\App\Entities\Trip::class)->create([
            'company_id' => $this->company_id,
            'vehicle_id' => $vehicles[1]->id,
            'pickup_date' => Carbon::now()->subDays(5),
            'deliver_date' => Carbon::now()->addDays(5)
        ]);
        
        $trips[2] = factory(\App\Entities\Trip::class)->create([
            'company_id' => $this->company_id,
            'vehicle_id' => $vehicles[2]->id,
            'pickup_date' => Carbon::now()->subDays(5),
            'deliver_date' => Carbon::now()->addDays(5)
        ]);
        
        // Maintenance tests
        $type = factory(\App\Entities\Type::class)->create([
            'company_id' => $this->company_id,
            'entity_key' => 'vehicle',
            'name' => 'repair',
        ]);
        
        $entries[0] = factory(\App\Entities\Entry::class)->create([
            'company_id' => $this->company_id,
            'entry_type_id' => $type->id,
            'datetime_ini' => Carbon::now()->subDays(2),
            'vehicle_id' => $vehicles[3]->id
        ]);
        
        $entries[1] = factory(\App\Entities\Entry::class)->create([
            'company_id' => $this->company_id,
            'entry_type_id' => $type->id,
            'datetime_ini' => Carbon::now()->subDays(2),
            'datetime_end' => Carbon::now()->addDays(5),
            'vehicle_id' => $vehicles[4]->id
        ]);
    
        $statistics = VehicleRepositoryEloquent::getVehiclesStatistics();

        $this->assertEquals($statistics['in_use']['result'], 3);
        $this->assertEquals($statistics['maintenance']['result'], 2);
        $this->assertEquals($statistics['available']['result'], 4);
    }
    
    public function testServicesStatistics()
    {
        $type = factory(\App\Entities\Type::class)->create([
            'company_id' => $this->company_id,
            'entity_key' => 'entry',
            'name' => 'service'
        ]);
        
        // In progress tests
        $services[] = factory(\App\Entities\Entry::class)->create([
            'company_id' => $this->company_id,
            'entry_type_id' => $type->id,
            'datetime_ini' => Carbon::now()->subDays(2),
        ]);
        
        $services[] = factory(\App\Entities\Entry::class)->create([
            'company_id' => $this->company_id,
            'entry_type_id' => $type->id,
            'datetime_ini' => Carbon::now()->subDays(2),
            'datetime_end' => Carbon::now()->addDays(5),
        ]);
        

        // Foreseen tests
        $services[] = factory(\App\Entities\Entry::class)->create([
            'company_id' => $this->company_id,
            'entry_type_id' => $type->id,
            'datetime_ini' => Carbon::now()->addDays(2),
        ]);
        
        $services[] = factory(\App\Entities\Entry::class)->create([
            'company_id' => $this->company_id,
            'entry_type_id' => $type->id,
            'datetime_ini' => Carbon::now()->addDays(2),
            'datetime_end' => Carbon::now()->addDays(5),
        ]);
        
        $services[] = factory(\App\Entities\Entry::class)->create([
            'company_id' => $this->company_id,
            'entry_type_id' => $type->id,
            'datetime_ini' => Carbon::now()->addDays(4),
            'datetime_end' => Carbon::now()->addDays(7),
        ]);
        
        // Accomplished tests
        $services[] = factory(\App\Entities\Entry::class)->create([
            'company_id' => $this->company_id,
            'entry_type_id' => $type->id,
            'datetime_ini' => Carbon::now()->subDays(2),
            'datetime_end' => Carbon::now()->subDays(5)
        ]);
        
        $statistics = EntryRepositoryEloquent::getServicesStatistics();

        $this->assertEquals($statistics['in_progress']['result'], 2);
        $this->assertEquals($statistics['foreseen']['result'], 3);
        $this->assertEquals($statistics['accomplished']['result'], 1);
    }
    
    public function testTripStatistics()
    {
        // In progress tests
        $trips[] = factory(\App\Entities\Trip::class)->create([
            'company_id' => $this->company_id,
            'pickup_date' => Carbon::now()->subDays(2),
        ]);
        
        $trips[] = factory(\App\Entities\Trip::class)->create([
            'company_id' => $this->company_id,
            'pickup_date' => Carbon::now()->subDays(2),
            'deliver_date' => Carbon::now()->addDays(5),
        ]);
        

        // Foreseen tests
        $trips[] = factory(\App\Entities\Trip::class)->create([
            'company_id' => $this->company_id,
            'pickup_date' => Carbon::now()->addDays(2),
        ]);
        
        $trips[] = factory(\App\Entities\Trip::class)->create([
            'company_id' => $this->company_id,
            'pickup_date' => Carbon::now()->addDays(2),
            'deliver_date' => Carbon::now()->addDays(5),
        ]);
        
        $trips[] = factory(\App\Entities\Trip::class)->create([
            'company_id' => $this->company_id,
            'pickup_date' => Carbon::now()->addDays(4),
            'deliver_date' => Carbon::now()->addDays(7),
        ]);
        
        // Accomplished tests
        $trips[] = factory(\App\Entities\Trip::class)->create([
            'company_id' => $this->company_id,
            'pickup_date' => Carbon::now()->subDays(2),
            'deliver_date' => Carbon::now()->subDays(5)
        ]);
        
        $statistics = TripRepositoryEloquent::getTripsStatistics();

        $this->assertEquals($statistics['in_progress']['result'], 2);
        $this->assertEquals($statistics['foreseen']['result'], 3);
        $this->assertEquals($statistics['accomplished']['result'], 1);
    }
    
    public function testLastsFuelCostStatistics()
    {
        $date = Carbon::now()->addMonthNoOverflow();
        for ($i = 1; $i < 7; $i++) {
            $date = $date->subMonthNoOverflow();
            for ($j = 1; $j < 3; $j++) {
                $trips[] = factory(\App\Entities\Trip::class)->create([
                    'company_id' => $this->company_id,
                    'pickup_date' => $date,
                    'fuel_cost' => $date->month * 1000
                ]);
            }
        }

        $statistics = TripRepositoryEloquent::getLastsFuelCostStatistics();

        $date = Carbon::now()->addMonthNoOverflow();
        for ($i = 1; $i < 7; $i++) {
            $date = $date->subMonthNoOverflow();
            $this->assertEquals($statistics[$date->month], $date->month * 1000 * 2);
        }
    }
    
    public function testLastsServiceCostStatistics()
    {
        $type = factory(\App\Entities\Type::class)->create([
            'company_id' => $this->company_id,
            'entity_key' => 'entry',
            'name' => 'service'
        ]);
        
        $date = Carbon::now()->addMonthNoOverflow();
        for ($i = 1; $i < 7; $i++) {
            $date = $date->subMonthNoOverflow();
            for ($j = 1; $j < 3; $j++) {
                $services[] = factory(\App\Entities\Entry::class)->create([
                    'company_id' => $this->company_id,
                    'entry_type_id' => $type->id,
                    'datetime_ini' => $date,
                    'cost' => $date->month * 1000
                ]);
            }
        }

        $statistics = EntryRepositoryEloquent::getLastsServiceCostStatistics();

        $date = Carbon::now()->addMonthNoOverflow();
        for ($i = 1; $i < 7; $i++) {
            $date = $date->subMonthNoOverflow();
            $this->assertEquals($statistics[$date->month], $date->month * 1000 * 2);
        }
    }
}
