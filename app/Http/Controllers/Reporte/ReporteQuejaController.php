<?php

namespace App\Http\Controllers\Reporte;

use App\Queja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReporteQuejaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reportes.listado-quejas');
    }

    public function listadoQueja(Request $request)
    {
        $ordenadores = array("q.id","q.no","q.nit","q.negocio","ae.nombre");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $quejas = DB::table('queja as q')
                ->join('actividad_economica as ae','q.actividad_economica_id','ae.id')
                ->select('q.id','q.no','q.negocio','q.nit','ae.nombre as actividad','q.status',DB::raw("date_format(q.created_at,'%d-%m-%Y') as fecha"))
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count =  DB::table('queja as q')
                ->join('actividad_economica as ae','q.actividad_economica_id','ae.id')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $quejas,
            );
        return response()->json($data, 200);
    }

    public function detalleHistorialQueja($id)
    {
        $registro = DB::table('queja as q')
                        ->join('actividad_economica as ae','q.actividad_economica_id','=','ae.id')
                        ->join('departamento as d','q.departamento_id','=','d.id')
                        ->join('municipio as m','q.municipio_id','=','m.id')
                        ->leftjoin('users as u','q.usuario_proceso_id','u.id')
                        ->select('q.no','q.nacionalidad','q.no_documento','q.fecha_documento','q.detalle','q.solicitud','q.telefono_contacto','q.correo_contacto','q.nombres','q.apellidos','q.nit','q.negocio','q.direccion','q.status','ae.nombre as actividad_economica','d.nombre as departamento','m.nombre as municipio',DB::raw('CONCAT_WS(" ",u.nombres," ",u.apellidos) as usuario'))
                        ->where('no',$id)
                        ->first();

        if(!$registro)
        {
            abort(404);
        }
        return view('reportes.listado-detalle-historial',['registro' => collect($registro)]);
    }
}
