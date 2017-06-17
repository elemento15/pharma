<?php namespace App\Http\Controllers;

use App\Product;

use Illuminate\Database\Eloquent\Model;

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

    /**
     * Display the specified resource.
     *
     * @param  string  $description
     * @return Response
     */
    public function search_description(Request $request)
    {
        $description = $request->description;
        $product = Product::where('description', 'like', $description.'%')->where('active', 1)->get();
        
        if ($product && count($product) > 0) {

            if (count($product) == 1) {
                $response = array('success' => true, 'product' => $product[0]);
            } else {
                $response = array('success' => true, 'product' => false);
            }

        } else {
            $response = array('success' => false, 'msg' => 'No se encontro el producto');
        }

        return Response::json($response);
    }

    /**
     * Get the price for a product
     *
     * @param  int  $id
     * @param  int  $vendor
     * @return Response
     */
    public function get_price(Request $request)
    {
        $product_id = $request->id;
        $vendor_id = $request->vendor;

        // get the product's price of the last vendor's purchase order
        $price = \DB::table('purchase_order_details AS det')
            ->join('purchase_orders AS po', 'po.id', '=', 'det.purchase_order_id')
            ->where('det.product_id', $product_id)
            ->where('po.vendor_id', $vendor_id)
            ->where('po.active', 1)
            ->orderBy('po.order_date', 'DESC')
            ->select('price')
            ->first();


        if (! $price) {
            // get the last product's price (any vendor)
            $price = \DB::table('purchase_order_details AS det')
                ->join('purchase_orders AS po', 'po.id', '=', 'det.purchase_order_id')
                ->where('det.product_id', $product_id)
                ->where('po.active', 1)
                ->orderBy('po.order_date', 'DESC')
                ->select('price')
                ->first();

            if (! $price) {
                $price = 0;
            }
        }

        return Response::json($price);
    }

}
