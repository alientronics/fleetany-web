<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use DatabaseTransactions;
    
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */

    public function setUp()
    {
        parent::setUp();
        $this->be(User::find(1));
    }
    
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
    
    public function createExecutive()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'Nome Usuario Executive',
            'email' => 'executive@alientronics.com.br',
            'password' => 'admin',
            'language' => 'pt-br',
            'contact_id' => 1,
            'company_id' => 1,
        ]);
    
        $user->assignRole('executive');
        return $user;
    }
    
    public function createManager()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'Nome Usuario Manager',
            'email' => 'manager@alientronics.com.br',
            'password' => 'admin',
            'language' => 'pt-br',
            'contact_id' => 1,
            'company_id' => 1,
        ]);
        
        $user->assignRole('manager');
        return $user;
    }
    
    public function createOperational()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'Nome Usuario Operational',
            'email' => 'operational@alientronics.com.br',
            'password' => 'admin',
            'language' => 'pt-br',
            'contact_id' => 1,
            'company_id' => 1,
        ]);
        
        $user->assignRole('operational');
        return $user;
    }
    
    public function createStaff()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'Nome Usuario Staff',
            'email' => 'staff@alientronics.com.br',
            'password' => 'admin',
            'language' => 'pt-br',
            'contact_id' => 1,
            'company_id' => 1,
        ]);
        
        $user->assignRole('staff');
        return $user;
    }
    
    /**
     * Assert that a given where condition does not matches a soft deleted record
     *
     * @param  string $table
     * @param  array  $data
     * @param  string $connection
     * @return $this
     */
    protected function seeIsNotSoftDeletedInDatabase($table, array $data, $connection = null)
    {
        $database = $this->app->make('db');
    
        $connection = $connection ?: $database->getDefaultConnection();
    
        $count = $database->connection($connection)
            ->table($table)
            ->where($data)
            ->whereNull('deleted_at')
            ->count();
    
        $this->assertGreaterThan(0, $count, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].',
            $table,
            json_encode($data)
        ));
    
        return $this;
    }
    
    /**
     * Assert that a given where condition matches a soft deleted record
     *
     * @param  string $table
     * @param  array  $data
     * @param  string $connection
     * @return $this
     */
    protected function seeIsSoftDeletedInDatabase($table, array $data, $connection = null)
    {
        $database = $this->app->make('db');
    
        $connection = $connection ?: $database->getDefaultConnection();
    
        $count = $database->connection($connection)
            ->table($table)
            ->where($data)
            ->whereNotNull('deleted_at')
            ->count();
    
        $this->assertGreaterThan(0, $count, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].',
            $table,
            json_encode($data)
        ));
    
        return $this;
    }
}
