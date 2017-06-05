function BaseController($scope, $route, $location, ModelService) {
	var me = this;
	var filter = [];
	var index = me.index || '/';
	var pagination = {
		page: 1,
		total: 1,
		limit: 5
	};

	// Must specify $scope.data i.e:
	// $scope.data = {
	// 	id: 0,
	// 	field1: '',
	// 	field2: '',
	// 	field3: ''
	// }

	// grid data
	$scope.list = [];

	// other
	$scope.title = me.title.new || 'Nuevo Registro';
	$scope.search = '';
	$scope.pageInfo = '1/1';

	$scope.save = function () {
		var data = me.validation()
		
		if (data) {
			ModelService.save(data)
				.success(function(response) {
					$location.path(index);
				})
				.error(function(response) {
					console.log('--- ERROR ---');
					console.log(response);
				});
		}
	}

	$scope.read = function () {
		ModelService.read({
			page: pagination.page,
			filter: filter,
			search: $scope.search
		}).success(function (response) {
			$scope.list = response.data;
			$scope.setPagination(response, pagination);
		}).error(function (response) {
			console.log('--- ERROR ---');
			console.log(response);
		});
	}

	$scope.delete = function (id) {
		if (confirm('Delete record?')) {
			ModelService.delete({
				id: id
			}).success(function (response) {
				$scope.paginate('first', true);
			}).error(function (response) {
				console.log('--- ERROR ---');
				console.log(response);
			});
		}
	}

	$scope.edit = function (id) {
		$scope.data.id = id;
		$scope.title = me.title.edit || 'Editar Registro';
		
		ModelService.get({
			id : id
		}).success(function(response) {
			$scope.data = response;
		}).error(function(response) {
			alert(response.msg || 'Server responded with error');
		});
	}

	$scope.searchData = function () {
		$scope.paginate('first', true);
	}

	$scope.setActive = function (record) {
		record.status_loading = true;
		
		ModelService.activate({
			id: record.id
		}).success(function (response) {
			record.active = response.data.active;
			record.status_loading = false;
		}).error(function (response) {
			console.log('--- ERROR ---');
			console.log(response);
			record.status_loading = false;
		});
	}

	$scope.setInactive = function (record) {
		record.status_loading = true;

		ModelService.deactivate({
			id: record.id
		}).success(function (response) {
			record.active = response.data.active;
			record.status_loading = false;
		}).error(function (response) {
			console.log('--- ERROR ---');
			console.log(response);
			record.status_loading = false;
		});
	}

	$scope.setPagination = function (data, pagination) {
		pagination.total = data.last_page;
		$scope.pageInfo = (pagination.page) +'/'+ pagination.total;
	}

	$scope.paginate = function (type, force) {
		var data = pagination;
		var page = data.current_page;

		switch (type) {
			case 'first' :
				data.page = 1;
				break;
			case 'previous' :
				if (data.page > 1) {
					data.page--;
				}
				break;
			case 'next' :
				if (data.page < data.total) {
					data.page++;
				}
				break;
			case 'last' :
				data.page = data.total;
				break;
		}

		if (page != data.page || force) {
			$scope.read(); // read only if page has changed
		}
	}

	$scope.$on('$viewContentLoaded', function (view) {
		if ($route.current.$$route.originalPath == index) {
			$scope.read(); // index view
		} else {
			var id = $route.current.params.id;
			if (id)
				$scope.edit(id); // edit mode
		}
	});
}
