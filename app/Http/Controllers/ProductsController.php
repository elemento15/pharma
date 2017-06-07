<?php namespace App\Http\Controllers;

use App\Product;

class ProductsController extends BaseController {

    protected $mainModel = 'App\Product';

    // params needen for index
    protected $searchFields = ['description', 'code'];
    protected $indexPaginate = 10;
    
    // params needed for store/update
    protected $defaultNulls = ['code'];
    protected $formRules = [
        'description'  => 'required'
    ];

}
