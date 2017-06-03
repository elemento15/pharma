var app = angular.module('mainApp', ['ngRoute']);

app.config(function ($routeProvider, $provide) {
	$routeProvider
		.when('/',
			{
				controller: 'HomeController',
				templateUrl: '/partials/home.html'
			})
		.when('/customers',{
				controller: 'CustomersController',
				templateUrl: '/partials/customers/index.html'
			})
		.when('/customers-new',
			{
				controller: 'CustomersController',
				templateUrl: '/partials/customers/edit.html'
			})
		.when('/customers-edit/:id',
			{
				controller: 'CustomersController',
				templateUrl: '/partials/customers/edit.html'
			})

		/*.when('/products-list',{
				controller: 'ProductsController',
				templateUrl: '/partials/products/index.html'
			})
		.when('/products-new',
			{
				controller: 'ProductsController',
				templateUrl: '/partials/products/edit.html'
			})
		.when('/products-edit/:id',
			{
				controller: 'ProductsController',
				templateUrl: '/partials/products/edit.html'
			})*/

		.otherwise({ redirectTo: '/' });
});
