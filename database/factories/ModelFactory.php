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
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Entities\Company::class, function ($faker) {
    return [
        'name' => $faker->name,
        'api_token' => str_random(10),
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