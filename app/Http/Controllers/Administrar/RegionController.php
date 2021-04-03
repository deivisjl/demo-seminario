<?php

namespace App\Http\Controllers\Administrar;

use App\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Services\Region\RegionServiceImpl;

class RegionController extends Controller
{
    private $regionService;

    public function __construct(RegionServiceImpl $__regionService)
    {
        $this->regionService = $__regionService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.region.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.region.create');
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

            $region = new Region();
            $region->nombre = $request->nombre;
            $region->save();

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
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $this->regionService->mostrarTodos($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $regione)
    {
        return view('administrar.region.edit', ['region' => $regione]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $regione)
    {
        try
        {
            $rules = [
                'nombre' => 'required'
            ];

            $this->validate($request, $rules);

            $regione->nombre = $request->nombre;
            $regione->save();

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
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $regione)
    {
        try
        {

            $regione->delete();

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
