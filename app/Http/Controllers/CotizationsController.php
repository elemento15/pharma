<?php namespace App\Http\Controllers;

use App\Cotization;
use App\CotizationDetail;

use App\Http\Controllers\Controller;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\CotizationPdf;

class CotizationsController extends BaseController {

    protected $mainModel = 'App\Cotization';

    // params needen for index
    protected $searchFields = ['id'];
    protected $indexPaginate = 10;
    protected $indexJoins = ['customer'];
    protected $orderBy = ['field' => 'id', 'type' => 'DESC'];

    // params needer for show
    protected $showJoins = ['customer', 'cotization_details', 'cotization_details.product'];
    
    // params needed for store/update
    protected $defaultNulls = [];
    protected $formRules = [
        'customer_id'  => 'required'
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

        // get default status for new cotization
        //$status = Status::where('type', 'COT')->where('is_default', 1)->first();
        
        try {
            $cotization = new Cotization;
            $cotization->customer_id = $request->customer_id;
            $cotization->comments = $request->comments;
            $cotization->cotization_date = date('Y-m-d H:i:s');
            //$cotization->status_id = $status->id;
            $cotization->save();

            foreach ($request->cotization_details as $item) {
                if (isset($item['_deleted'])) continue;

                $dt = new CotizationDetail;
                $dt->product_id = intval($item['product_id']);
                $dt->quantity = floatval($item['quantity']);
                $dt->price = floatval($item['price']);
                $dt->subtotal = $dt->quantity * $dt->price;
                $dt->iva = floatval($item['iva']);
                $dt->iva_amount = $dt->subtotal * ($dt->iva / 100);
                $dt->total = $dt->iva_amount + $dt->subtotal;
                $dt->lot = $item['lot'];
                $dt->expiration = $item['expiration'];
                
                $subtotal += $dt->subtotal;
                $iva_amount += $dt->iva_amount;
                $total += $dt->total;

                $cotization->cotization_details()->save($dt);
            }

            $cotization->subtotal = $subtotal;
            $cotization->iva_amount = $iva_amount;
            $cotization->total = $total;
            $cotization->save();

            return $cotization;

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
        return Response::json(array('msg' => 'No puede editar una Cotización'), 500);
    }

    /**
     * Cancel cotization
     *
     * @param  int  $id
     * @return Response
     */
    public function cancel($id)
    {
        $record = Cotization::find($id);

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
     * Change status to cotization.
     *
     * @param  int  $id
     * @param  int  $status_id
     * @return Response
     */
    /*public function change_status($id, Request $request)
    {
        $record = Cotization::find($id);

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
     * Print cotization pdf
     *
     * @param  int  $id
     * @return Response
     */
    public function print_pdf($id, Request $request)
    {
        $order = Cotization::find($id);
        $pdf = new CotizationPdf($order);
        return Response::make($pdf->Output('I', 'cotizacion_'.$id.'.pdf'), 200, array('content-type' => 'application/pdf'));
    }

}
