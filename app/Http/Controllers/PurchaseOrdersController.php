<?php namespace App\Http\Controllers;

use App\PurchaseOrder;
use App\PurchaseOrderDetail;
use App\VendorPrice;

use App\Http\Controllers\Controller;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\PurchaseOrderPdf;

class PurchaseOrdersController extends BaseController {

    protected $mainModel = 'App\PurchaseOrder';

    // params needen for index
    protected $searchFields = ['id'];
    protected $indexPaginate = 10;
    protected $indexJoins = ['vendor'];
    protected $orderBy = ['field' => 'id', 'type' => 'DESC'];

    // params needer for show
    protected $showJoins = ['vendor', 'purchase_order_details', 'purchase_order_details.product'];
    
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
        $subtotal = 0;
        $iva_amount = 0;
        $total = 0;

        // get default status for new purchase order
        //$status = Status::where('type', 'PO')->where('is_default', 1)->first();
        
        try {
            $purchase = new PurchaseOrder;
            $purchase->vendor_id = $request->vendor_id;
            $purchase->comments = $request->comments;
            $purchase->order_date = date('Y-m-d H:i:s');
            //$purchase->status_id = $status->id;
            $purchase->save();

            foreach ($request->purchase_order_details as $item) {
                if (isset($item['_deleted'])) continue;

                $dt = new PurchaseOrderDetail;
                $dt->product_id = intval($item['product_id']);
                $dt->quantity = floatval($item['quantity']);
                $dt->price = floatval($item['price']);
                $dt->subtotal = $dt->quantity * $dt->price;
                $dt->iva = floatval($item['iva']);
                $dt->iva_amount = $dt->subtotal * ($dt->iva / 100);
                $dt->total = $dt->iva_amount + $dt->subtotal;
                
                $subtotal += $dt->subtotal;
                $iva_amount += $dt->iva_amount;
                $total += $dt->total;

                $purchase->purchase_order_details()->save($dt);

                // update vendor price
                $this->updateVendorPrice($dt->product_id, $purchase->vendor_id, $dt->price);
            }

            $purchase->subtotal = $subtotal;
            $purchase->iva_amount = $iva_amount;
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
        return Response::json(array('msg' => 'No puede editar una Order de Compra'), 500);
    }

    /**
     * Cancel cotization
     *
     * @param  int  $id
     * @return Response
     */
    public function cancel($id)
    {
        $record = PurchaseOrder::find($id);

        if (! $record) {
            return Response::json(array('msg' => 'Registro no encontrado'), 500);
        }

        if ($record->status != 'N') {
            return Response::json(array('msg' => 'Estado inválido'), 500);
        }

        $record->status = 'C';

        if ($record->save()) {
            return Response::json($record);
        } else {
            return Response::json(array('msg' => 'Error al cancelar'), 500);
        }
    }

    /**
     * Change status to purchase order.
     *
     * @param  int  $id
     * @param  int  $status_id
     * @return Response
     */
    /*public function change_status($id, Request $request)
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
    }*/

    /**
     * Print purchase order pdf
     *
     * @param  int  $id
     * @return Response
     */
    public function print_pdf($id, Request $request)
    {
        $order = PurchaseOrder::find($id);
        $pdf = new PurchaseOrderPdf($order);
        return Response::make($pdf->Output('I', 'orden_'.$id.'.pdf'), 200, array('content-type' => 'application/pdf'));
    }


    private function updateVendorPrice($product_id, $vendor_id, $price)
    {
        $vendor_price = VendorPrice::where('vendor_id', $vendor_id)->where('product_id', $product_id)->first();
        
        if ($vendor_price) {
            $vendor_price->price = $price;
            $vendor_price->save();
        } else {
            $vendor_price = new VendorPrice;
            $vendor_price->vendor_id = $vendor_id;
            $vendor_price->product_id = $product_id;
            $vendor_price->price = $price;
            $vendor_price->save();
        }
    }

}
