<?php

use Illuminate\Database\Seeder;
use App\Entities\Contact;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->delete();
        Contact::create(
                array(  'company_id' => 1,
                        'contact_type_id' => 3,
                        'name' => 'Vendor Name',
                        'license_no' => 'license')
            );
        Contact::create(
                array(  'company_id' => 1,
                        'contact_type_id' => 3,
                        'name' => 'Driver Name',
                        'license_no' => 'license')
            );
    }
}
