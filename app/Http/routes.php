<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('home', 'HomeController@index');
Route::resource('/contact', 'HomeController@contact');

Route::group(
    [
    'middleware' => ['auth',
    'acl'],
    'can' => 'view.trip'],
    function () {
        Route::resource('trip', 'TripController');
    }
);

Route::group(
    [
        'middleware' => ['auth',
            'acl'],
        'can' => 'view.part'],
    function () {
        Route::resource('part', 'PartController');
    }
);

Route::group(
    [
    'middleware' => ['auth',
    'acl'],
    'can' => 'view.entry'],
    function () {
        Route::resource('entry', 'EntryController');
    }
);

Route::group(
    [
    'middleware' => ['auth',
    'acl'],
    'can' => 'view.contact'],
    function () {
        Route::resource('contact', 'ContactController');
    }
);

Route::group(
    [
    'middleware' => ['auth',
    'acl'],
    'can' => 'view.type'],
    function () {
        Route::resource('type', 'TypeController');
    }
);

Route::group(
    [
    'middleware' => ['auth',
    'acl'],
    'can' => 'view.model'],
    function () {
        Route::resource('model', 'ModelController');
    }
);

Route::group(
    [
    'middleware' => ['auth',
    'acl'],
    'can' => 'view.company'],
    function () {
        Route::resource('company', 'CompanyController');
    }
);

Route::group(
    [
    'middleware' => ['auth',
    'acl'],
    'can' => 'view.vehicle'],
    function () {
        Route::resource('vehicle', 'VehicleController');
    }
);

Route::group(
    [
    'middleware' => ['auth',
    'acl'],
    'can' => 'view.user'],
    function () {
        Route::resource('user', 'UserController');
    }
);

Route::get('vehicle/{id}/{dateini}/{dateend}', 'VehicleController@show');

Route::get('trip/destroy/{id}', 'TripController@destroy');
Route::get('part/destroy/{id}', 'PartController@destroy');
Route::get('entry/destroy/{id}', 'EntryController@destroy');
Route::get('contact/destroy/{id}', 'ContactController@destroy');
Route::get('type/destroy/{id}', 'TypeController@destroy');
Route::get('model/destroy/{id}', 'ModelController@destroy');
Route::get('vehicle/destroy/{id}', 'VehicleController@destroy');
Route::get('user/destroy/{id}', 'UserController@destroy');

Route::get('getModels/{entityKey}/{idType?}', 'ModelController@getModelsByType');
Route::get('getPartsByVehicle/{idVehicle}', 'PartController@getPartsByVehicle');

Route::get('sensor/download/{idPart}', 'TireController@downloadData');

Route::get('profile', 'UserController@showProfile');
Route::put('updateProfile/{id}', 'UserController@updateProfile');

Route::get('invite', 'InviteController@showInvite');
Route::put('invite', 'InviteController@storeInvite');
Route::get('create-account/{token}', 'Auth\AuthController@showCreateAccount');
Route::put('create-account/{token}', 'Auth\AuthController@createAccount');

Route::get('auth/social/{provider}/{token?}', 'SocialLoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'SocialLoginController@handleProviderCallback');
Route::get('auth/{provider}/callback', 'SocialLoginController@handleProviderCallback');
Route::get('auth/logout', 'SocialLoginController@getLogout');

Route::post('tires/position/swap', 'TireController@positionSwap');
Route::post('tires/position/remove', 'TireController@positionRemove');
Route::post('tires/position/add', 'TireController@positionAdd');
Route::post('tires/details', 'TireController@details');
Route::get('tires/updateStorage/{vehicle_id}', 'TireController@updateStorage');
Route::post('parts/create', 'PartController@store');
Route::post('models/create', 'ModelController@storeByDialog');
Route::post('types/create', 'TypeController@storeByDialog');
Route::post('vehicle/map/updateDetail', 'VehicleController@updateMapDetail');

Route::post('vehicle/dashboard/tires', 'VehicleDashboardController@tires');
Route::post('vehicle/dashboard/localization', 'VehicleDashboardController@localization');

Route::get('vehicle/fleet/dashboard', 'VehicleDashboardController@fleet');
Route::get('vehicle/fleet/dashboard/{updateDatetime}', 'VehicleDashboardController@fleetGpsAndSensorData');
Route::get('vehicle/fleet/dashboard/{updateDatetime}/{vehicleId}', 'VehicleDashboardController@fleetGpsAndSensorData');

Route::bind(
    'users',
    function ($value, $route) {
        return App\Entities\User::whereId($value)->first();
    }
);

Route::controllers(
    [
    'auth' => 'Auth\AuthController',
    ]
);
