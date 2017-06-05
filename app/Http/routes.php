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

Route::get('/', 'HomeController@index');

// Route::get('home', 'HomeController@index');

Route::resource('customers', 'CustomersController');
Route::post('customers/{id}/activate', 'CustomersController@activate');
Route::post('customers/{id}/deactivate', 'CustomersController@deactivate');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
