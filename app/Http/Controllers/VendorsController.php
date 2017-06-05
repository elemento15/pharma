<?php namespace App\Http\Controllers;

use App\Vendor;

class VendorsController extends BaseController {

    protected $mainModel = 'App\Vendor';

    // params needen for index
    protected $searchFields = ['name', 'rfc', 'contact', 'email'];
    protected $indexPaginate = 10;
    
    // params needed for store/update
    protected $defaultNulls = ['rfc'];
    protected $formRules = [
        'name'  => 'required',
        'email' => 'email'
    ];

}
