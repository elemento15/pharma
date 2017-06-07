app.controller('PurchaseOrdersController', function ($scope, $http, $route, $location, $ngConfirm, PurchaseOrderService, toastr) {
	this.index = '/purchase-orders';
	this.title = {
		new:  'Nueva Orden de Compra',
		edit: 'Editar Orden de Compra'
	}

	this.validation = function () {
		var data = $scope.data;
		var invalid = false;

		if (! data.vendor_id) {
			invalid = toastr.warning('Proveedor requerido', 'Validaciones');
		}

		return (invalid) ? false : data;
	}

	// model data
	$scope.data = {
		id:        0,
		vendor_id: '',
		order_date: '',
		total: 0,
		active: 1,
		comments: ''
	};

	BaseController.call(this, $scope, $route, $location, $ngConfirm, PurchaseOrderService, toastr);
});