app.controller('PurchaseOrdersController', function ($scope, $http, $route, $location, $timeout, $ngConfirm, $uibModal, PurchaseOrderService, ProductService, VendorService, toastr) {
	this.index = '/purchase-orders';
	this.title = {
		new:  'Nueva Orden de Compra',
		edit: 'Orden de Compra: '
	}

	this.validation = function () {
		var data = $scope.data;
		var invalid = false;

		if (! data.vendor) {
			invalid = toastr.warning('Proveedor requerido', 'Validaciones');
		} else {
			data.vendor_id = data.vendor.id; // select2
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
		purchase_order_details: [],
		vendor: null
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

	$scope.getVendors = function () {
		VendorService.read({
			filters: [{ field: 'active', value: 1 }]
		}).success(function (response) {
			$scope.vendorsList = response;
		}).error(function (response) {
			toastr.error(response.msg || 'Error en el servidor');
		});
	}

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
					$scope.getProductPrice(response.product);
					$scope.focusQuantity();
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

	$scope.searchDescription = function (evt) {
		var description;

		if (evt.keyCode == 13) {
			evt.preventDefault();

			description = $scope.product.description;

			ProductService.search_description({
				description: description
			}).success(function (response) {
				if (response.success) {
					if (response.product) {
						$scope.setProduct(response.product);
						$scope.getProductPrice(response.product);
						$scope.focusQuantity();
					} else {
						$scope.openSearch(description);
					}
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

		$scope.calculateTotal();
	}

	$scope.openSearch = function (search) {
		var modal = $uibModal.open({
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: '/partials/templates/modalProducts.html',
			controller: 'ModalProductsSearch',
			controllerAs: '$ctrl',
			resolve: {
				items: function () {
					return {
						search: search || ''
					};
				}
			}
		});

		modal.result.then(function (product) {
			if (product) {
				$scope.setProduct(product);
				$scope.getProductPrice(product);
				$scope.focusQuantity();
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

	$scope.deleteProduct = function (product, key) {
		$scope.data.purchase_order_details[key]._deleted = true;
		$scope.calculateTotal()
	}

	$scope.calculateTotal = function () {
		var total = 0;
		$scope.data.purchase_order_details.forEach(function (item) {
			if (! item._deleted) {
				total += item.total;
			}
		});

		$scope.data.total = total;
	}

	$scope.focusQuantity = function () {
		$timeout(function () {
			$('input[ng-model="product.quantity"]').focus().select();
	    }, 100);
	}

	$scope.getProductPrice = function (product) {
		// if no vendor selected, set prico = 0
		if (! $scope.data.vendor) {
			$scope.product.price = 0;
			return false;
		}

		ProductService.get_price({
			id: product.id,
			vendor: $scope.data.vendor.id
		}).success(function (response) {
			$scope.product.price = response.price;
		}).error(function (response) {
			toastr.error(response.msg || 'Error en el servidor');
		});
	}

	$scope.getVendors();

	BaseController.call(this, $scope, $route, $location, $ngConfirm, PurchaseOrderService, toastr);
});