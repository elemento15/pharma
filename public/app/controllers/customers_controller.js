app.controller('CustomersController', function ($scope, $http, $route, $location, CustomerService, toastr) {
	this.index = '/customers';
	this.title = {
		new:  'Nuevo Cliente',
		edit: 'Editar Cliente'
	}

	this.validation = function () {
		var data = $scope.data;

		if (! data.name) {
			alert('Nombre requerido');
			return false;
		}

		return data;
	}

	// model data
	$scope.data = {
		id:        0,
		name: '',
		rfc: '',
		contact: '',
		phone: '',
		mobile: '',
		email: '',
		address: '',
		active: 1,
		comments: ''
	};

	BaseController.call(this, $scope, $route, $location, CustomerService, toastr);
});