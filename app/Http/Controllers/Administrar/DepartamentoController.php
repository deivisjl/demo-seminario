<?php

namespace App\Http\Controllers\Administrar;

use App\Region;
use App\Municipio;
use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.departamento.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regiones = Region::all();

        return view('administrar.departamento.create',['regiones' => $regiones]);
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
                'region' => 'required|min:1'
            ];

            $this->validate($request, $rules);

            $departamento = new Departamento();
            $departamento->nombre = $request->nombre;
            $departamento->region_id = $request->region;
            $departamento->save();

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
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("d.id","d.nombre","r.nombre");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $departamentos = DB::table('departamento as d')
                ->join('region as r','d.region_id','r.id')
                ->select('d.id','d.nombre','r.nombre as region')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('departamento as d')
                ->join('region as r','d.region_id','r.id')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $departamentos,
            );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamento $departamento)
    {
        $regiones = Region::all();

        return view('administrar.departamento.edit',['departamento' => $departamento,'regiones' => $regiones]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departamento $departamento)
    {
        try
        {
            $rules = [
                'nombre' => 'required',
                'region' => 'required|min:1'
            ];

            $this->validate($request, $rules);

            $departamento->nombre = $request->nombre;
            $departamento->region_id = $request->region;
            $departamento->save();

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
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamento $departamento)
    {
        try
        {

            $departamento->delete();

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
    /**
     * Retorna el listado de los municipios de un departamento
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function municipio($id)
    {
        $municipios = Municipio::where('departamento_id',$id)
                            ->orderBy('nombre','asc')
                            ->get();

        return response()->json(['data' => $municipios],200);
    }
}
