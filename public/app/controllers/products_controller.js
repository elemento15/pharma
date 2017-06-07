app.controller('ProductsController', function ($scope, $http, $route, $location, $ngConfirm, ProductService, toastr) {
	this.index = '/products';
	this.title = {
		new:  'Nuevo Producto',
		edit: 'Editar Producto'
	}

	this.validation = function () {
		var data = $scope.data;
		var invalid = false;

		if (! data.description) {
			invalid = toastr.warning('Descripción requerida', 'Validaciones');
		}

		return (invalid) ? false : data;
	}

	// model data
	$scope.data = {
		id: 0,
		code: '',
		description: '',
		active: 1,
		comments: ''
	};

	BaseController.call(this, $scope, $route, $location, $ngConfirm, ProductService, toastr);
});