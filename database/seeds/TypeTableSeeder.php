<?php

use Illuminate\Database\Seeder;
use App\Entities\Type;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->delete();
        Type::forceCreate(
                [  'entity_key' => 'entry',
                        'name' => 'service',
                        'company_id' => 1]
            );
        Type::forceCreate(
                [  'entity_key' => 'vehicle',
                        'name' => 'car',
                        'company_id' => 1]
            );
        Type::forceCreate(
                [  'entity_key' => 'contact',
                        'name' => 'user',
                        'company_id' => 1]
            );
        Type::forceCreate(
                [  'entity_key' => 'contact',
                        'name' => 'driver',
                        'company_id' => 1]
            );
        Type::forceCreate(
                [  'entity_key' => 'contact',
                        'name' => 'vendor',
                        'company_id' => 1]
            );
        Type::forceCreate(
                [  'entity_key' => 'trip',
                        'name' => 'delivery',
                        'company_id' => 1]
            );
        Type::forceCreate(
                [  'entity_key' => 'contact',
                        'name' => 'detail',
                        'company_id' => 1]
            );
        Type::forceCreate(
                [  'entity_key' => 'fuel',
                        'name' => 'unleaded',
                        'company_id' => 1]
            );
        Type::forceCreate(
                [  'entity_key' => 'fuel',
                        'name' => 'premium',
                        'company_id' => 1]
            );
        Type::forceCreate(
                [  'entity_key' => 'part',
                        'name' => 'tire',
                        'locked' => 1,
                        'company_id' => 1]
            );
        Type::forceCreate(
                [  'entity_key' => 'part',
                        'name' => 'sensor',
                        'company_id' => 1]
            );
    }
}
