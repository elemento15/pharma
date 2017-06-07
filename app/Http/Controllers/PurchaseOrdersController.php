<?php namespace App\Http\Controllers;

use App\PurchaseOrder;

class PurchaseOrdersController extends BaseController {

	protected $mainModel = 'App\PurchaseOrder';

    // params needen for index
    protected $searchFields = ['order_date'];
    protected $indexPaginate = 10;
    
    // params needed for store/update
    protected $defaultNulls = [];
    protected $formRules = [
        'vendor_id'  => 'required'
    ];

}
