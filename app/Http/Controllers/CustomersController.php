<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Customer;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$search = $request->search;
		$model = new Customer;
		
		if ($search) {
			$model = $model
				->where('name', 'like', '%'.$search.'%')
				->orWhere('rfc', 'like', '%'.$search.'%')
				->orWhere('contact', 'like', '%'.$search.'%')
				->orWhere('email', 'like', '%'.$search.'%');
		}

		return $model->orderBy('name', 'ASC')->paginate(10);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		return Customer::create($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Customer::find($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$rules = array(
            'name'       => 'required',
            'email'      => 'email'
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
        	return 'ERROR';
        } else {
			$record = Customer::find($id);
			$record->name = $request->name;
			$record->rfc = $request->rfc;
			$record->contact = $request->contact;
			$record->phone = $request->phone;
			$record->mobile = $request->mobile;
			$record->email = $request->email;
			$record->address = $request->address;
			$record->comments = $request->comments;

			$record->save();
			return $record;
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$record = Customer::find($id);
		if ($record->delete()) {
			return "Eliminado";
		} else {
			return "Error";
		}
	}

	public function activate($id)
	{
		$record = Customer::find($id);
		$record->active = 1;
		if ($record->save()) {
			return Response::json(array('code' => 200, 'data' => $record));
		} else {
			return Response::json(array('code' => 500, 'msg' => 'No se pudo activar'));
		}
	}

	public function deactivate($id)
	{
		$record = Customer::find($id);
		$record->active = 0;
		if ($record->save()) {
			return Response::json(array('code' => 200, 'data' => $record));
		} else {
			return Response::json(array('code' => 500, 'msg' => 'No se pudo desactivar'));
		}
	}

}
