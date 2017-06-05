<?php namespace App\Http\Controllers;

use App\Product;

class ProductsController extends BaseController {

    protected $mainModel = 'App\Product';

    // params needen for index
    protected $searchFields = ['description'];
    protected $indexPaginate = 10;
    
    // params needed for store/update
    protected $defaultNulls = [];
    protected $formRules = [
        'description'  => 'required'
    ];

}
