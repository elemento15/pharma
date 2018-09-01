<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PaymentTypesController extends BaseController {

	protected $mainModel = 'App\PaymentType';

    // params needen for index
    protected $searchFields = ['id'];
    protected $indexPaginate = 10;
    protected $indexJoins = [];
    protected $orderBy = ['field' => 'id', 'type' => 'ASC'];

    // params needer for show
    protected $showJoins = [];
    
    // params needed for store/update
    protected $defaultNulls = [];
    protected $formRules = [];

    protected $allowDelete = false;

}
