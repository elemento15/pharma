<?php namespace App\Http\Controllers;

use App\Product;

use Response;
use Illuminate\Http\Request;

class ProductsController extends BaseController {

    protected $mainModel = 'App\Product';

    // params needen for index
    protected $searchFields = ['description', 'code'];
    protected $indexPaginate = 10;
    protected $indexJoins = [];
    protected $orderBy = ['field' => 'description', 'type' => 'ASC'];
    
    // params needer for show
    protected $showJoins = [];

    // params needed for store/update
    protected $defaultNulls = ['code'];
    protected $formRules = [
        'description'  => 'required'
    ];

    protected $allowDelete = true;


    /**
     * Display the specified resource.
     *
     * @param  string  $code
     * @return Response
     */
    public function search_code(Request $request)
    {
    	$code = $request->code;
    	$product = Product::where('code', $code)->where('active', 1)->first();
    	
    	if ($product) {
    		$response = array('success' => true, 'product' => $product);
    	} else {
    		$response = array('success' => false, 'msg' => 'No se encontro el producto');
    	}

    	return Response::json($response);
    }

}
