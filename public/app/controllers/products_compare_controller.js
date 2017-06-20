app.controller('ProductsCompareController', function ($scope, $http, $route, $location, $ngConfirm, ProductService, toastr) {

	$scope.list = [];
	$scope.selected = false;

	$scope.read = function () {
		ProductService.rpt_compare({
			//page: pagination.page,
			//filters: $scope.mapFilters(),
			//search: $scope.search
		}).success(function (response) {
			$scope.list = response;
			//$scope.setPagination(response, pagination);
		}).error(function (response) {
			toastr.error(response.msg || 'Error en el servidor');
		});
	}

	$scope.productSelected = function (record) {
		$scope.selected = record;
	}


	$scope.$on('$viewContentLoaded', function (view) {
		$scope.read();
	});

});