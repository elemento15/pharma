app.controller('VendorsController', function ($scope, $http, $route, $location, $ngConfirm, VendorService, toastr) {
	this.index = '/vendors';
	this.title = {
		new:  'Nuevo Proveedor',
		edit: 'Editar Proveedor'
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

	BaseController.call(this, $scope, $route, $location, $ngConfirm, VendorService, toastr);
});