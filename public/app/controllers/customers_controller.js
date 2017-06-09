app.controller('CustomersController', function ($scope, $http, $route, $location, $ngConfirm, CustomerService, toastr) {
	this.index = '/customers';
	this.title = {
		new:  'Nuevo Cliente',
		edit: 'Editar Cliente'
	}

	this.validation = function () {
		var data = $scope.data;
		var invalid = false;

		if (! data.name) {
			invalid = toastr.warning('Nombre requerido', 'Validaciones');
		}

		if (data.rfc && !app.regexpRFC.test(data.rfc)) {
			invalid = toastr.warning('RFC Inválido', 'Validaciones');
		}

		if (data.email && !app.regexpEmail.test(data.email)) {
			invalid = toastr.warning('Email Inválido', 'Validaciones');
		}

		return (invalid) ? false : data;
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

	$scope.filters = {
		active: ''
	}

	BaseController.call(this, $scope, $route, $location, $ngConfirm, CustomerService, toastr);
});