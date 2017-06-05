app.controller('ProductsController', function ($scope, $http, $route, $location, ProductService, toastr) {
	this.index = '/products';
	this.title = {
		new:  'Nuevo Producto',
		edit: 'Editar Producto'
	}

	this.validation = function () {
		var data = $scope.data;

		if (! data.description) {
			alert('Descripción requerida');
			return false;
		}

		return data;
	}

	// model data
	$scope.data = {
		id: 0,
		description: '',
		active: 1,
		comments: ''
	};

	BaseController.call(this, $scope, $route, $location, ProductService, toastr);
});