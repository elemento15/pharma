<?php namespace App\Http\Controllers;

use App\Status;

class StatusesController extends BaseController {

    protected $mainModel = 'App\Status';

    // params needen for index
    protected $searchFields = ['name', 'type'];
    protected $indexPaginate = 10;
    protected $indexJoins = [];
    protected $orderBy = ['field' => 'name', 'type' => 'ASC'];
    
    // params needer for show
    protected $showJoins = [];

    // params needed for store/update
    protected $defaultNulls = [];
    protected $formRules = [];

    protected $allowDelete = false;

}