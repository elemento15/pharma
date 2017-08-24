app.controller('CotizationsController', function ($scope, $http, $route, $location, $timeout, $ngConfirm, $uibModal, CotizationService, ProductService, CustomerService, StatusService, toastr) {
	this.index = '/cotizations';
	this.title = {
		new:  'Nueva Cotización',
		edit: 'Cotización: '
	}

	this.validation = function () {
		var data = $scope.data;
		var invalid = false;

		if (! data.customer) {
			invalid = toastr.warning('Cliente requerido', 'Validaciones');
		} else {
			data.customer_id = data.customer.id; // select2
		}

		return (invalid) ? false : data;
	}

	// model data
	$scope.data = {
		id:        0,
		customer_id: '',
		status_id: '',
		cotization_date: '',
		total: 0,
		active: 1,
		comments: '',
		cotization_details: [],
		customer: null,
		status: null
	};

	$scope.filters = {
		active: '',
		status_id: ''
	}

	$scope.product = {
		id: 0,
		code: '',
		description: '',
		quantity: '',
		price: '',
		total: 0,
		lot: '',
		expiration: ''
	};

	$scope.input_quantity = 0;
	$scope.input_price = 0;

	$scope.customersList = [];
	$scope.statusList = [];

	$scope.getCustomers = function () {
		CustomerService.read({
			filters: [{ field: 'active', value: 1 }]
		}).success(function (response) {
			$scope.customersList = response;
		}).error(function (response) {
			toastr.error(response.msg || 'Error en el servidor');
		});
	}

	$scope.getStatuses = function () {
		StatusService.read({
			filters: [{ field: 'type', value: 'COT' }]
		}).success(function (response) {
			$scope.statusList = response;
		}).error(function (response) {
			toastr.error(response.msg || 'Error en el servidor');
		});
	}

	$scope.searchCode = function (evt) {
		var code;
		
		if (evt.keyCode == 13) {
			evt.preventDefault();

			code = $scope.product.code;

			if (code == '') {
				$scope.focusDescription();
				return false;
			}

			ProductService.search_code({
				code: code
			}).success(function (response) {
				if (response.success) {
					$scope.setProduct(response.product);
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
						$('input[ng-model="product.lot"]').focus().select();
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
				case 'price'      : $('input[ng-model="product.price"]').focus().select();
				                    break;
				case 'add'        : $('#btnAddProduct').focus();
				                    break;
				case 'expiration' : $('input[ng-model="product.expiration"]').focus().select();
				                    break;
				case 'quantity'   : $('input[ng-model="product.quantity"]').focus().select();
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

		if (parseFloat(product.price) == 0) {
			toastr.warning('Ingrese un precio válido');
			$('input[ng-model="product.price"]').focus().select();
			return false;
		}

		if (parseFloat(product.quantity) == 0) {
			toastr.warning('Ingrese una cantidad válida');
			$('input[ng-model="product.quantity"]').focus().select();
			return false;
		}
		
		$scope.data.cotization_details.push({
			product_id: product.id,
			quantity: product.quantity,
			price: product.price,
			total: product.total,
			product: {
				id: product.id,
				code: product.code,
				description: product.description
			},
			lot: product.lot,
			expiration: product.expiration
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
			total: 0,
			lot: '',
			expiration: ''
		};
	}

	$scope.getTotalProduct = function () {
		var product = $scope.product;
		$scope.product.total = product.quantity * product.price;
	}

	$scope.deleteProduct = function (product, key) {
		$scope.data.cotization_details[key]._deleted = true;
		$scope.calculateTotal();
		$scope.focusCode();
	}

	$scope.calculateTotal = function () {
		var total = 0;
		$scope.data.cotization_details.forEach(function (item) {
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

	$scope.focusCode = function () {
		$timeout(function () {
			$('input[ng-model="product.code"]').focus().select();
	    }, 100);
	}

	$scope.focusDescription = function () {
		$timeout(function () {
			$('input[ng-model="product.description"]').focus().select();
	    }, 100);
	}

	$scope.openChangeStatus = function (cotization) {
		var modal = $uibModal.open({
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: '/partials/templates/modalChangeStatus.html',
			controller: 'ModalChangeStatus',
			controllerAs: '$ctrl',
			size: 'sm',
			resolve: {
				items: function () {
					return {
						statusList: $scope.statusList
					};
				}
			}
		});

		modal.result.then(function (status) {
			if (status) {
				$scope.changeStatus(cotization, status);
			}
		});
	}

	$scope.changeStatus = function (cotization, status) {
		CotizationService.change_status({
			id: cotization.id,
			status: status.id
		}).success(function (response) {
			cotization.status_id = response.id;
			cotization.status = response;
		}).error(function (response) {
			toastr.error(response.msg || 'Error en el servidor');
		});
	}

	$scope.editDetail = function (detail, type) {
		if (type == 'quantity') {
			$scope.input_quantity = parseFloat(detail.quantity);
			detail.editing_quantity = true;
			$timeout(function () {
				$('input[ng-model="input_quantity"]').focus().select();
		    }, 50);
		}

		if (type == 'price') {
			$scope.input_price = parseFloat(detail.price);
			detail.editing_price = true;
			$timeout(function () {
				$('input[ng-model="input_price"]').focus().select();
		    }, 50);
		}

		if (type == 'lot') {
			$scope.input_lot = detail.lot;
			detail.editing_lot = true;
			$timeout(function () {
				$('input[ng-model="input_lot"]').focus().select();
		    }, 50);
		}

		if (type == 'expiration') {
			$scope.input_expiration = detail.expiration;
			detail.editing_expiration = true;
			$timeout(function () {
				$('input[ng-model="input_expiration"]').focus().select();
		    }, 50);
		}
	}

	$scope.endEditDetail = function (detail, type, evt) {
		var value;

		if (type == 'quantity' || type == 'price') {
			value = parseFloat(evt.target.value);
			if (! value) {
				toastr.warning('Capture un número válido', 'Validaciones');
				$scope.clearEditingDetails('all');
				return false;
			}
		} else {
			value = evt.target.value;
		}
		
		if (type == 'quantity') {
			detail.quantity = value;
		}

		if (type == 'price') {
			detail.price = value;
		}

		if (type == 'lot') {
			detail.lot = value;
		}

		if (type == 'expiration') {
			detail.expiration = value;
		}

		$scope.clearEditingDetails(type);
		detail.total = detail.quantity * detail.price;
		$scope.calculateTotal();
	}

	$scope.keyPressDetail = function (evt, type) {
		var key = evt.keyCode;

		if (key == 27) {
			$scope.clearEditingDetails(type);
		}

		if (key == 13) {
			evt.target.blur();
		}
	}

	$scope.clearEditingDetails = function (type) {
		$scope.data.cotization_details.forEach(function (item) {
			if (type == 'quantity' || type == 'all') {
				item.editing_quantity = false;
			}

			if (type == 'price' || type == 'all') {
				item.editing_price = false;
			}

			if (type == 'lot' || type == 'all') {
				item.editing_lot = false;
			}

			if (type == 'expiration' || type == 'all') {
				item.editing_expiration = false;
			}
		});
	}

	$scope.getCustomers();
	$scope.getStatuses();

	BaseController.call(this, $scope, $route, $location, $ngConfirm, CotizationService, toastr);
});