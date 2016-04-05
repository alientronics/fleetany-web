<?php

use Illuminate\Database\Seeder;
use App\Entities\Contact;
use App\Entities\Company;

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
                        'name' => 'Administrator',
                        'country' => 'Country',
                        'city' => 'City')
            );
        $company = Company::find(1);
        $company->contact_id = 1;
        $company->save();
        Contact::create(
                array(  'company_id' => 1,
                        'contact_type_id' => 5,
                        'name' => 'Vendor Name')
            );
        Contact::create(
                array(  'company_id' => 1,
                        'contact_type_id' => 4,
                        'name' => 'Driver Name',
                        'license_no' => 'license')
            );
    }
}
