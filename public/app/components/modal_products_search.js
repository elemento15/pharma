app.controller('ModalProductsSearch', function ($uibModalInstance, items, ProductService) {
  var $ctrl = this;
  
  var filter = [];
  var pagination = {
    page: 1,
    total: 1,
    limit: 5
  };

  $ctrl.products = [];
  $ctrl.search = '';
  $ctrl.pageInfo = '1/1';

  $ctrl.read = function () {
    ProductService.read({
      page: pagination.page,
      filter: filter,
      search: $ctrl.search
    }).success(function (response) {
      $ctrl.products = response.data;
      $ctrl.setPagination(response, pagination);
    }).error(function (response) {
      toastr.error(response.msg || 'Error en el servidor');
    });
  }

  $ctrl.ok = function () {
    // $uibModalInstance.close($ctrl.selected.item);
    $uibModalInstance.close();
  };

  $ctrl.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

  $ctrl.setPagination = function (data, pagination) {
    pagination.total = data.last_page;
    $ctrl.pageInfo = (pagination.page) +'/'+ pagination.total;
  };

  $ctrl.paginate = function (type, force) {
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
      $ctrl.read(); // read only if page has changed
    }
  };

  $ctrl.read();

});