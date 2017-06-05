var app = angular.module('mainApp', ['ngRoute', 'toastr']);

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

		.when('/vendors',{
				controller: 'VendorsController',
				templateUrl: '/partials/vendors/index.html'
			})
		.when('/vendors-new',
			{
				controller: 'VendorsController',
				templateUrl: '/partials/vendors/edit.html'
			})
		.when('/vendors-edit/:id',
			{
				controller: 'VendorsController',
				templateUrl: '/partials/vendors/edit.html'
			})

		.when('/products',{
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
			})

		.otherwise({ redirectTo: '/' });
});
