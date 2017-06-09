<?php namespace App\Http\Controllers;

use App\Customer;

class CustomersController extends BaseController {

    protected $mainModel = 'App\Customer';

    // params needen for index
    protected $searchFields = ['name', 'rfc', 'contact', 'email'];
    protected $indexPaginate = 10;
    protected $indexJoins = [];
    protected $orderBy = ['field' => 'name', 'type' => 'ASC'];
    
    // params needer for show
    protected $showJoins = [];

    // params needed for store/update
    protected $defaultNulls = ['rfc'];
    protected $formRules = [
        'name'  => 'required',
        'email' => 'email'
    ];

    protected $allowDelete = true;

}
