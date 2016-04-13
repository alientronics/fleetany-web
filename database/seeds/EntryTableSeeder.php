<?php

use Illuminate\Database\Seeder;
use App\Entities\Entry;

class EntryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entries')->delete();
        Entry::create(
                [  'entry_type_id' => 1,
                        'vendor_id' => 1,
                        'vehicle_id' => 1,
                        'datetime_ini' => '2016-01-01',
                        'datetime_end' => '2016-01-01',
                        'entry_number' => 123,
                        'cost' => 321,
                        'description' => 'Descricao Entry',
                        'company_id' => 1]
            );
    }
}
