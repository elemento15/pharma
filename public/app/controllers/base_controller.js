function BaseController($scope, $route, $location, ModelService) {
	var me = this;
	var filter = [];
	var index = me.index || '/';
	var pagination = {
		page: 0,
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
			start:  pagination.page * pagination.limit,
			length: pagination.limit,
			filter: filter,
			search: $scope.search
		}).success(function (response) {
			$scope.list = response;
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

	$scope.setPagination = function (data, pagination) {
		pagination.total = Math.ceil(data.count / pagination.limit);
		$scope.pageInfo = (pagination.page + 1) +'/'+ pagination.total;
	}

	$scope.paginate = function (type, force) {
		var data = pagination;
		var page = data.page;

		switch (type) {
			case 'first' :
				data.page = 0;
				break;
			case 'previous' :
				if (data.page > 0) {
					data.page--;
				}
				break;
			case 'next' :
				if (data.page < data.total - 1) {
					data.page++;
				}
				break;
			case 'last' :
				data.page = data.total -1;
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
