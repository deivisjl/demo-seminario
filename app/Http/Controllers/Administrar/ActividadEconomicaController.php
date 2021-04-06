<?php

namespace App\Http\Controllers\Administrar;

use App\ActividadEconomica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class ActividadEconomicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.actividad-economica.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.actividad-economica.create');
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
                'nombre' => 'required'
            ];

            $this->validate($request, $rules);

            $actividad = new ActividadEconomica();
            $actividad->nombre = $request->nombre;
            $actividad->save();

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
     * @param  \App\ActividadEconomica  $actividadEconomica
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombre");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $actividades = DB::table('actividad_economica')
                ->select('id','nombre')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('actividad_economica')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $actividades,
            );
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ActividadEconomica  $actividadEconomica
     * @return \Illuminate\Http\Response
     */
    public function edit(ActividadEconomica $actividad_economica)
    {
        return view('administrar.actividad-economica.edit',['actividad' => $actividad_economica]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ActividadEconomica  $actividadEconomica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActividadEconomica $actividad_economica)
    {
        try
        {
            $rules = [
                'nombre' => 'required'
            ];

            $this->validate($request, $rules);

            $actividad_economica->nombre = $request->nombre;
            $actividad_economica->save();

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
     * @param  \App\ActividadEconomica  $actividadEconomica
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActividadEconomica $actividad_economica)
    {
        try
        {

            $actividad_economica->delete();

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
