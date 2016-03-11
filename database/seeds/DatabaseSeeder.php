<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('CompanyTableSeeder');
        $this->call('TypeTableSeeder');
        $this->call('ContactTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('ModelTableSeeder');
        $this->call('VehicleTableSeeder');
        $this->call('EntryTableSeeder');
        $this->call('TripTableSeeder');
        $this->call('AclTableSeeder');
    }
}
