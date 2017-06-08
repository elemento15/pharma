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

Route::resource('customers', 'CustomersController');
Route::post('customers/{id}/activate', 'CustomersController@activate');
Route::post('customers/{id}/deactivate', 'CustomersController@deactivate');

Route::resource('vendors', 'VendorsController');
Route::post('vendors/{id}/activate', 'VendorsController@activate');
Route::post('vendors/{id}/deactivate', 'VendorsController@deactivate');

Route::resource('products', 'ProductsController');
Route::post('products/{id}/activate', 'ProductsController@activate');
Route::post('products/{id}/deactivate', 'ProductsController@deactivate');
Route::post('products/search_code', 'ProductsController@search_code');

Route::resource('purchase_orders', 'PurchaseOrdersController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
