app.controller('VendorsController', function ($scope, $http, $route, $location, VendorService) {
	this.index = '/vendors';
	this.title = {
		new:  'Nuevo Proveedor',
		edit: 'Editar Proveedor'
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

	BaseController.call(this, $scope, $route, $location, VendorService);
});