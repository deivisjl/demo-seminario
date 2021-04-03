<?php
namespace App\Services\Region;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Region\IRegionService;


class RegionServiceImpl implements IRegionService
{
    public function guardar(Request $request)
    {

    }
    public function obtenerPorId($id)
    {

    }
    public function mostrarTodos(Request $request)
    {
        $ordenadores = array("id","nombre");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $regiones = DB::table('region')
                ->select('id','nombre')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('region')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $regiones,
            );
        return response()->json($data, 200);
    }
    public function actualizar(Request $request)
    {

    }
    public function eliminar($id)
    {

    }
}
