<?php namespace App\Http\Controllers;

use App\Cotization;
use App\CotizationDetail;
// use App\Product;
use App\Status;

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
    protected $indexJoins = ['customer', 'status'];
    protected $orderBy = ['field' => 'id', 'type' => 'DESC'];

    // params needer for show
    protected $showJoins = ['customer', 'status', 'cotization_details', 'cotization_details.product'];
    
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
        $total = 0;

        // get default status for new cotization
        $status = Status::where('type', 'COT')->where('is_default', 1)->first();
        
        try {
            $cotization = new Cotization;
            $cotization->customer_id = $request->customer_id;
            $cotization->comments = $request->comments;
            $cotization->cotization_date = date('Y-m-d H:i:s');
            $cotization->status_id = $status->id;
            $cotization->save();

            foreach ($request->cotization_details as $item) {
                if (isset($item['_deleted'])) continue;

                $detail = new CotizationDetail;
                $detail->product_id = $item['product_id'];
                $detail->quantity = $item['quantity'];
                $detail->price = $item['price'];
                $detail->total = $item['quantity'] * $item['price'];
                $total += $detail->total;

                $cotization->cotization_details()->save($detail);
            }

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
        $rules = $this->formRules;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::json(array('msg' => 'Revise las validaciones'), 501);
        } else {
            $cotization = Cotization::find($id);
            $total = 0;

            if (! $cotization) {
                return Response::json(array('msg' => 'Cotización inexistente'), 500);
            }

            try {
                $cotization->customer_id = $request->customer_id;
                $cotization->comments = $request->comments;
                $cotization->save();

                foreach ($request->cotization_details as $item) {
                    $id_detail = isset($item['id']) ? $item['id'] : 0;
                    
                    if ($id_detail) {
                        $detail = CotizationDetail::find($item['id']);

                        if (isset($item['_deleted'])) {
                            $detail->delete();
                            continue;
                        }

                    } else {
                        if (isset($item['_deleted'])) continue;
                        $detail = new CotizationDetail;
                    }
                    
                    $detail->product_id = $item['product_id'];
                    $detail->quantity = $item['quantity'];
                    $detail->price = $item['price'];
                    $detail->total = $item['quantity'] * $item['price'];

                    if ($id_detail) {
                        $detail->save();
                    } else {
                        $cotization->cotization_details()->save($detail);
                    }

                    $total += $detail->total;
                }

                $cotization->total = $total;
                $cotization->save();

            } catch (Exception $e) {
                return Response::json(array('msg' => 'Error al guardar'), 500);
            }
            
            return $cotization;
        }
    }

    /**
     * Change status to cotization.
     *
     * @param  int  $id
     * @param  int  $status_id
     * @return Response
     */
    public function change_status($id, Request $request)
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
    }

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
