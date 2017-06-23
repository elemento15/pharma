<?php namespace App\Http\Controllers;

use App\PurchaseOrder;
use App\PurchaseOrderDetail;
use App\Product;
use App\Status;

use App\Http\Controllers\Controller;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseOrdersController extends BaseController {

    protected $mainModel = 'App\PurchaseOrder';

    // params needen for index
    protected $searchFields = ['id'];
    protected $indexPaginate = 10;
    protected $indexJoins = ['vendor', 'status'];
    protected $orderBy = ['field' => 'id', 'type' => 'DESC'];

    // params needer for show
    protected $showJoins = ['vendor', 'status', 'purchase_order_details', 'purchase_order_details.product'];
    
    // params needed for store/update
    protected $defaultNulls = [];
    protected $formRules = [
        'vendor_id'  => 'required'
    ];

    protected $allowDelete = false;


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $total = 0;

        // get default status for new purchase order
        $status = Status::where('type', 'PO')->where('is_default', 1)->first();
        
        try {
            $purchase = new PurchaseOrder;
            $purchase->vendor_id = $request->vendor_id;
            $purchase->comments = $request->comments;
            $purchase->order_date = date('Y-m-d H:i:s');
            $purchase->status_id = $status->id;
            $purchase->save();

            foreach ($request->purchase_order_details as $item) {
                if (isset($item['_deleted'])) continue;

                $detail = new PurchaseOrderDetail;
                $detail->product_id = $item['product_id'];
                $detail->quantity = $item['quantity'];
                $detail->price = $item['price'];
                $detail->total = $item['quantity'] * $item['price'];
                $total += $detail->total;

                $purchase->purchase_order_details()->save($detail);

                // mark product as worked
                $product = Product::find($item['product_id']);
                $product->setWorked();
            }

            $purchase->total = $total;
            $purchase->save();

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
            $total = 0;

            if (! $purchase) {
                return Response::json(array('msg' => 'Orden de Compra inexistente'), 500);
            }

            try {
                $purchase->vendor_id = $request->vendor_id;
                $purchase->comments = $request->comments;
                $purchase->save();

                foreach ($request->purchase_order_details as $item) {
                    $id_detail = isset($item['id']) ? $item['id'] : 0;
                    
                    if ($id_detail) {
                        $detail = PurchaseOrderDetail::find($item['id']);

                        if (isset($item['_deleted'])) {
                            $detail->delete();
                            continue;
                        }

                    } else {
                        if (isset($item['_deleted'])) continue;
                        $detail = new PurchaseOrderDetail;

                        // mark product as worked
                        $product = Product::find($item['product_id']);
                        $product->setWorked();
                    }

                    $detail->product_id = $item['product_id'];
                    $detail->quantity = $item['quantity'];
                    $detail->price = $item['price'];
                    $detail->total = $item['quantity'] * $item['price'];

                    if ($id_detail) {
                        $detail->save();
                    } else {
                        $purchase->purchase_order_details()->save($detail);
                    }

                    $total += $detail->total;
                }

                $purchase->total = $total;
                $purchase->save();

            } catch (Exception $e) {
                return Response::json(array('msg' => 'Error al guardar'), 500);
            }
            
            return $purchase;
        }
    }

    /**
     * Change status to purchase order.
     *
     * @param  int  $id
     * @param  int  $status_id
     * @return Response
     */
    public function change_status($id, Request $request)
    {
        $record = PurchaseOrder::find($id);

        if (! $record) {
            return Response::json(array('msg' => 'Registro no encontrado'), 500);
        }

        $record->status_id = $request->status;
        
        if ($record->save()) {
            return Response::json($record->status()->first());
        } else {
            return Response::json(array('msg' => 'Error al activar'), 500);
        }
    }

}
