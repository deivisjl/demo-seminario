<?php

namespace App\Http\Controllers\Administrar;

use App\Municipio;
use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.municipio.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = Departamento::orderBy('nombre','ASC')->get();

        return view('administrar.municipio.create',['departamentos' => $departamentos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $rules = [
                'nombre' => 'required',
                'departamento' => 'required|min:1'
            ];

            $this->validate($request, $rules);

            $municipio = new Municipio();
            $municipio->nombre = $request->nombre;
            $municipio->departamento_id = $request->departamento;
            $municipio->save();

            return response()->json(['data' => 'Registro guardado con éxito'],200);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()],423);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("m.id","m.nombre","d.nombre");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $municipios = DB::table('municipio as m')
                ->join('departamento as d','m.departamento_id','d.id')
                ->select('m.id','m.nombre','d.nombre as departamento')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('municipio as m')
                ->join('departamento as d','m.departamento_id','d.id')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $municipios,
            );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function edit(Municipio $municipio)
    {
        $departamentos = Departamento::orderBy('nombre','ASC')->get();

        return view('administrar.municipio.edit',['municipio' => $municipio,'departamentos' => $departamentos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Municipio $municipio)
    {
        try
        {
            $rules = [
                'nombre' => 'required',
                'departamento' => 'required|min:1'
            ];

            $this->validate($request, $rules);

            $municipio->nombre = $request->nombre;
            $municipio->departamento_id = $request->departamento;
            $municipio->save();

            return response()->json(['data' => 'Registro actualizado con éxito'],200);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()],423);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Municipio $municipio)
    {
        try
        {

            $municipio->delete();

            return response()->json(['data' => 'Registro eliminado con éxito'],200);
        }
        catch (\Exception $e)
        {
            if ($e instanceof QueryException) {
                $codigo = $e->errorInfo[1];

                if ($codigo == 1451) {
                    return response()->json(['error' => 'No se puede eliminar porque tiene registros asociados'],423);
                }
            }
            return response()->json(['error' => $e->getMessage()],423);
        }
    }
}
