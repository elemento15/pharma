app.controller('ModalPayment', function ($uibModalInstance, items, CotizationService, toastr) {
  var $ctrl = this;

  
  $ctrl.payment = {
    amount: 0,
    type_id: '',
    comments: ''
  };
  $ctrl.cotization = items.cotization;
  $ctrl.paymentTypesList = items.paymentTypesList;
  
  $ctrl.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

  $ctrl.save = function () {
    CotizationService.savePayment({
      cotization_id: $ctrl.cotization.id,
      amount: $ctrl.payment.amount,
      payment_type_id: $ctrl.payment.type_id,
      comments: $ctrl.payment.comments
    }).success(function (response) {
      toastr.success('Abono creado exitosamente');
      $uibModalInstance.close();
    }).error(function (response) {
      toastr.error(response.msg || 'Error en el servidor');
    });;
  }

});