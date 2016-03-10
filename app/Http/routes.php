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

Route::resource('trip', 'TripController');
Route::resource('entry', 'EntryController');
Route::resource('contact', 'ContactController');
Route::resource('type', 'TypeController');
Route::resource('model', 'ModelController');
Route::resource('company', 'CompanyController');
Route::resource('vehicle', 'VehicleController');
Route::resource('user', 'UserController');

Route::get('trip/destroy/{id}', 'TripController@destroy');
Route::get('entry/destroy/{id}', 'EntryController@destroy');
Route::get('contact/destroy/{id}', 'ContactController@destroy');
Route::get('type/destroy/{id}', 'TypeController@destroy');
Route::get('model/destroy/{id}', 'ModelController@destroy');
Route::get('company/destroy/{id}', 'CompanyController@destroy');
Route::get('vehicle/destroy/{id}', 'VehicleController@destroy');
Route::get('user/destroy/{id}', 'UserController@destroy');

Route::get('profile', 'UserController@showProfile');

Route::put('updateProfile/{id}', 'UserController@updateProfile');

Route::get('auth/social/{provider}', 'SocialLoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'SocialLoginController@handleProviderCallback');
Route::get('auth/{provider}/callback', 'SocialLoginController@handleProviderCallback');
Route::get('auth/logout', 'SocialLoginController@getLogout');

Route::bind(
    'users',
    function ($value, $route) {
        return App\User::whereId($value)->first();
    }
);

Route::controllers(
    [
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
    ]
);
