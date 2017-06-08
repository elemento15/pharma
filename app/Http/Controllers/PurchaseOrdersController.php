<?php namespace App\Http\Controllers;

use App\PurchaseOrder;
use App\PurchaseOrderDetail;

use App\Http\Controllers\Controller;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseOrdersController extends BaseController {

    protected $mainModel = 'App\PurchaseOrder';

    // params needen for index
    protected $searchFields = ['order_date'];
    protected $indexPaginate = 10;
    protected $indexJoins = ['vendor'];

    // params needer for show
    protected $showJoins = ['vendor', 'purchase_order_details', 'purchase_order_details.product'];
    
    // params needed for store/update
    protected $defaultNulls = [];
    protected $formRules = [
        'vendor_id'  => 'required'
    ];


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $purchase = new PurchaseOrder;
            $purchase->vendor_id = $request->vendor_id;
            $purchase->comments = $request->comments;
            $purchase->order_date = date('Y-m-d H:i:s');
            $purchase->save();

            foreach ($request->purchase_order_details as $item) {
                $detail = new PurchaseOrderDetail;
                $detail->product_id = $item['product_id'];
                $detail->quantity = $item['quantity'];
                $detail->price = $item['price'];
                $detail->total = $item['quantity'] * $item['price'];

                $purchase->purchase_order_details()->save($detail);
            }

            return $purchase;

        } catch (Exception $e) {
            return Response::json(array('msg' => 'Error al guardar'), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {

        $rules = $this->formRules;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::json(array('msg' => 'Revise las validaciones'), 501);
        } else {
            $purchase = PurchaseOrder::find($id);

            if (! $purchase) {
                return Response::json(array('msg' => 'Orden de Compra inexistente'), 500);
            }

            try {
                $purchase->vendor_id = $request->vendor_id;
                $purchase->comments = $request->comments;
                $purchase->save();

                foreach ($request->purchase_order_details as $item) {
                    $detail = new PurchaseOrderDetail;
                    $detail->product_id = $item['product_id'];
                    $detail->quantity = $item['quantity'];
                    $detail->price = $item['price'];
                    $detail->total = $item['quantity'] * $item['price'];

                    $purchase->purchase_order_details()->save($detail);
                }

            } catch (Exception $e) {
                return Response::json(array('msg' => 'Error al guardar'), 500);
            }
            
            return $purchase;
        }
    }

}
