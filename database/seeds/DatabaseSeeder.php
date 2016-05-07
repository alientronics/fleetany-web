<?php

use Illuminate\Database\Seeder;
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
        $this->call('PartTableSeeder');
        $this->call('AclTableSeeder');
    }
}
