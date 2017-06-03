app.controller('ProductsController', function ($scope, $http, $route, $location, ProductService) {
	this.index = '/products-list';
	this.title = {
		new:  'New Product',
		edit: 'Edit Product'
	}

	this.validation = function () {
		var data = $scope.data;

		if (! data.code) {
			alert('Code needed');
			return false;
		}

		if (! data.description) {
			alert('Description needed');
			return false;
		}

		return data;
	}

	// model data
	$scope.data = {
		id:          0,
		code:        '',
		description: '',
		price:       '',
		active:      '',
		comments:    ''
	};

	BaseController.call(this, $scope, $route, $location, ProductService);
});