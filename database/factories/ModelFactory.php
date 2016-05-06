<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Entities\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'contact_id' => 1,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Entities\Company::class, function ($faker) {
    return [
        'name' => $faker->name
    ];
});

$factory->define(App\Entities\Contact::class, function ($faker) {
    return [
        'name' => $faker->name,
        'contact_type_id' => 1,
        'company_id' => 1,
		'deleted_at' => null,
    ];
});

$factory->define(App\Entities\Entry::class, function ($faker) {
    return [
        'entry_type_id' => 1,
        'company_id' => 1,
		'deleted_at' => null,
    ];
});

$factory->define(App\Entities\Gps::class, function ($faker) {
    return [
        'vehicle_id' => 1,
        'company_id' => 1,
        'latitude' => 51,
        'longitude' => 31,
		'deleted_at' => null,
        'driver_id' => 1,
    ];
});

$factory->define(App\Entities\Model::class, function ($faker) {
    return [
        'name' => $faker->name,
        'model_type_id' => 1,
        'company_id' => 1,
		'deleted_at' => null,
    ];
});

$factory->define(App\Entities\Part::class, function ($faker) {
    return [
        'vehicle_id' => 1,
        'part_type_id' => 1,
        'part_model_id' => 1,
        'company_id' => 1,
        'cost' => 1,
        'name' => $faker->name,
        'number' => 1,
        'position' => 1,
        'lifecycle' => 1,
		'deleted_at' => null,
    ];
});

$factory->define(App\Entities\PartEntry::class, function ($faker) {
    return [
        'entry_id' => 1,
        'part_id' => 1,
		'deleted_at' => null,
    ];
});

$factory->define(App\Entities\PartHistory::class, function ($faker) {
    return [
        'vehicle_id' => 1,
        'part_id' => 1,
        'position' => 1,
		'deleted_at' => null,
    ];
});

$factory->define(App\Entities\TireSensor::class, function ($faker) {
    return [
        'part_id' => 1,
        'temperature' => 1,
        'pressure' => 1,
        'latitude' => 1,
        'longitude' => 1,
        'number' => 1,
		'deleted_at' => null,
    ];
});

$factory->define(App\Entities\Trip::class, function ($faker) {
    return [
        'vehicle_id' => 1,
        'trip_type_id' => 1,
        'company_id' => 1,
		'deleted_at' => null,
    ];
});

$factory->define(App\Entities\Type::class, function ($faker) {
    return [
        'name' => $faker->name,
        'company_id' => 1,
		'deleted_at' => null,
    ];
});

$factory->define(App\Entities\Vehicle::class, function ($faker) {
    return [
        'model_vehicle_id' => 1,
        'company_id' => 1,
		'deleted_at' => null,
    ];
});