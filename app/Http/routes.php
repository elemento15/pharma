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
Route::post('products/search_description', 'ProductsController@search_description');
Route::post('products/get_price', 'ProductsController@get_price');
Route::post('products/rpt_compare', 'ProductsController@rpt_compare');

Route::resource('purchase_orders', 'PurchaseOrdersController');
Route::post('purchase_orders/{id}/activate', 'PurchaseOrdersController@activate');
Route::post('purchase_orders/{id}/deactivate', 'PurchaseOrdersController@deactivate');
Route::post('purchase_orders/{id}/change_status', 'PurchaseOrdersController@change_status');
Route::get('purchase_orders/{id}/print_pdf', 'PurchaseOrdersController@print_pdf');

Route::resource('cotizations', 'CotizationsController');
Route::post('cotizations/{id}/activate', 'CotizationsController@activate');
Route::post('cotizations/{id}/deactivate', 'CotizationsController@deactivate');
Route::post('cotizations/{id}/change_status', 'CotizationsController@change_status');
Route::get('cotizations/{id}/print_pdf', 'CotizationsController@print_pdf');


Route::resource('statuses', 'StatusesController');

Route::resource('vendor_prices', 'VendorPricesController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
