<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller {

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
        $model = new $this->mainModel;
        
        if ($search) {
            foreach ($this->searchFields as $key => $field) {
                if ($key == 0) {
                    $model = $model->where($field, 'like', '%'.$search.'%');
                } else {
                    $model = $model->orWhere($field, 'like', '%'.$search.'%');
                }
            }
        }

        return $model->orderBy($this->searchFields[0], 'ASC')->paginate($this->indexPaginate);
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
        $mainModel = $this->mainModel;

        foreach ($this->defaultNulls as $item) {
            $request[$item] = ($request[$item] == '') ? null : $request[$item];
        }

        try {
            return $mainModel::create($request->all());
        } catch (Exception $e) {
            return Response::json(array('msg' => 'Error al guardar'), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $mainModel = $this->mainModel;
        $record = $mainModel::find($id);

        if ($record) {
            return $record;
        } else {
            return Response::json(array('msg' => 'Registro no encontrado'), 500);
        }
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
        $mainModel = $this->mainModel;
        
        foreach ($this->defaultNulls as $item) {
            $request[$item] = ($request[$item] == '') ? null : $request[$item];
        }

        $rules = $this->formRules;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::json(array('msg' => 'Revise las validaciones'), 501);
        } else {
            $record = $mainModel::find($id);

            if (! $record) {
                return Response::json(array('msg' => 'Registro no encontrado'), 500);
            }

            try {
                $record->fill($request->all())->save();
            } catch (Exception $e) {
                return Response::json(array('msg' => 'Error al guardar'), 500);
            }
        
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
        $mainModel = $this->mainModel;
        
        $record = $mainModel::find($id);

        if (! $record) {
            return Response::json(array('msg' => 'Registro no encontrado'), 500);
        }

        if (! $record->delete()) {
            return Response::json(array('msg' => 'Error al eliminar'), 500);
        }
    }

    public function activate($id)
    {
        $mainModel = $this->mainModel;

        $record = $mainModel::find($id);

        if (! $record) {
            return Response::json(array('msg' => 'Registro no encontrado'), 500);
        }

        $record->active = 1;
        
        if ($record->save()) {
            return Response::json($record);
        } else {
            return Response::json(array('msg' => 'Error al activar'), 500);
        }
    }

    public function deactivate($id)
    {
        $mainModel = $this->mainModel;

        $record = $mainModel::find($id);

        if (! $record) {
            return Response::json(array('msg' => 'Registro no encontrado'), 500);
        }

        $record->active = 0;
        
        if ($record->save()) {
            return Response::json($record);
        } else {
            return Response::json(array('msg' => 'Error al desactivar'), 500);
        }
    }

}