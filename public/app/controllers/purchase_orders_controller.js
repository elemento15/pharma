app.controller('PurchaseOrdersController', function ($scope, $http, $route, $location, $ngConfirm, $uibModal, PurchaseOrderService, ProductService, VendorService, toastr) {
	this.index = '/purchase-orders';
	this.title = {
		new:  'Nueva Orden de Compra',
		edit: 'Editar Orden de Compra'
	}

	this.validation = function () {
		var data = $scope.data;
		var invalid = false;

		data.vendor_id = data.vendor.id; // select2

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
		comments: '',
		purchase_order_details: []
	};

	$scope.filters = {
		active: ''
	}

	$scope.product = {
		id: 0,
		code: '',
		description: '',
		quantity: '',
		price: '',
		total: 0
	};

	$scope.vendorsList = [];

	VendorService.read({
		//page: pagination.page,
		//filter: filter,
		//search: $scope.search
	}).success(function (response) {
		$scope.vendorsList = response;
	}).error(function (response) {
		toastr.error(response.msg || 'Error en el servidor');
	});

	$scope.searchCode = function (evt) {
		var code;
		
		if (evt.keyCode == 13) {
			evt.preventDefault();

			code = $scope.product.code;

			ProductService.search_code({
				code: code
			}).success(function (response) {
				if (response.success) {
					$scope.setProduct(response.product);
					$('input[ng-model="product.quantity"]').focus().select();
				} else {
					toastr.warning(response.msg);
					$scope.clearProduct();
					$('input[ng-model="product.code"]').focus().select();
				}
			}).error(function (response) {
				toastr.error(response.msg || 'Error en el servidor');
			});
		}
	}

	$scope.setProduct = function (product) {
		$scope.product = {
			id: product.id,
			code: product.code,
			description: product.description,
			quantity: 1,
			price: 0,
			total: 0
		};
	}

	$scope.setFocus = function (evt, opt) {
		if (evt.keyCode == 13) {
			evt.preventDefault();

			switch (opt) {
				case 'price' : $('input[ng-model="product.price"]').focus().select();
				               break;
				case 'add'   : $('#btnAddProduct').focus();
				               break;
			}
		}
	}

	$scope.addProduct = function () {
		var product = $scope.product;

		if (! product.id) {
			toastr.warning('Seleccione un producto válido');
			$('input[ng-model="product.code"]').focus().select();
			return false;
		}
		
		$scope.data.purchase_order_details.push({
			product_id: product.id,
			quantity: product.quantity,
			price: product.price,
			total: product.total,
			product: {
				id: product.id,
				code: product.code,
				description: product.description
			}
		});

		$scope.clearProduct();
		$('input[ng-model="product.code"]').focus().select();
	}

	$scope.openSearch = function () {
		$uibModal.open({
			// animation: $ctrl.animationsEnabled,
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: '/partials/templates/modalProducts.html',
			controller: 'ModalProductsSearch',
			controllerAs: '$ctrl',
			// size: size,
			// appendTo: parentElem,
			resolve: {
				items: function () {
					// return $ctrl.items;
				}
			}
		});
	}

	$scope.clearProduct = function () {
		$scope.product = {
			id: 0,
			code: '',
			description: '',
			quantity: '',
			price: '',
			total: 0
		};
	}

	$scope.getTotalProduct = function () {
		var product = $scope.product;
		$scope.product.total = product.quantity * product.price;
	}


	BaseController.call(this, $scope, $route, $location, $ngConfirm, PurchaseOrderService, toastr);
});