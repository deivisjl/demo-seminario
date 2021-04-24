<?php

namespace App\Http\Controllers\Reporte;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReporteController extends Controller
{
    private $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reportes.index');
    }

    public function graficoTotalQueja(Request $request)
    {
        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'))->addDays(1);

        $this->validate($request, $rules);

        $reporte = DB::table('queja as q')
                        ->select(DB::raw('COUNT(q.id) as cantidad'))
                        ->whereBetween('q.created_at', [$desde, $hasta])
                        ->first();

        return response()->json(['data' => $reporte->cantidad],200);
    }

    public function graficoPorRegion(Request $request)
    {

        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'))->addDays(1);

        $this->validate($request, $rules);

        $reporte = DB::table('queja as q')
                        ->join('departamento as d','q.departamento_id','=','d.id')
                        ->join('region as r','d.region_id','=','r.id')
                        ->select(DB::raw('COUNT(q.id) as cantidad'),'r.nombre as region')
                        ->whereBetween('q.created_at', [$desde, $hasta])
                        ->groupBy('r.nombre')
                        ->get();

        return response()->json(['data' => $this->formatoGaficoPorRegion($reporte)],200);
    }

    public function formatoGaficoPorRegion($datos)
    {
        $respuesta = array();

        $respuesta[0] = ['Región','Quejas'];

        foreach ($datos as $key => $item)
        {
            $respuesta[$key+1] = [$item->region, (int)$item->cantidad];
        }

        return $respuesta;
    }

    public function graficoPorDepartamento(Request $request)
    {
        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'))->addDays(1);

        $this->validate($request, $rules);

        $reporte = DB::table('queja as q')
                        ->join('departamento as d','q.departamento_id','=','d.id')
                        ->select(DB::raw('COUNT(q.id) as cantidad'),'d.nombre as departamento')
                        ->whereBetween('q.created_at', [$desde, $hasta])
                        ->groupBy('d.nombre')
                        ->get();

        return response()->json(['data' => $this->formatoGaficoPorDepto($reporte)],200);
    }


    public function formatoGaficoPorDepto($datos)
    {
        $respuesta = array();

        $respuesta[0] = ['Departamento','Quejas'];

        foreach ($datos as $key => $item)
        {
            $respuesta[$key+1] = [$item->departamento, (int)$item->cantidad];
        }

        return $respuesta;
    }

    public function graficoTop5(Request $request)
    {
        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'))->addDays(1);

        $this->validate($request, $rules);

        $reporte = DB::table('queja as q')
                        ->select(DB::raw('COUNT(q.nit) as cantidad'),'q.negocio')
                        ->whereBetween('q.created_at', [$desde, $hasta])
                        ->groupBy('q.negocio')
                        ->orderBy(DB::raw('COUNT(q.nit)'),'desc')
                        ->take(5)
                        ->get();

        return response()->json(['data' => $this->formatoGaficoTop5($reporte)],200);
    }

    public function formatoGaficoTop5($datos)
    {
        $respuesta = array();

        $respuesta[0] = ['Entidad','Quejas'];

        foreach ($datos as $key => $item)
        {
            $respuesta[$key+1] = [$item->negocio, (int)$item->cantidad];
        }

        return $respuesta;
    }

    public function graficoTop5Actividad(Request $request)
    {
        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'))->addDays(1);

        $this->validate($request, $rules);

        $reporte = DB::table('queja as q')
                        ->join('actividad_economica as ae','q.actividad_economica_id','=','ae.id')
                        ->select(DB::raw('COUNT(ae.id) as cantidad'),'ae.nombre as actividad')
                        ->whereBetween('q.created_at', [$desde, $hasta])
                        ->groupBy('ae.nombre')
                        ->orderBy(DB::raw('COUNT(ae.id)'),'desc')
                        ->take(5)
                        ->get();

        return response()->json(['data' => $this->formatoGaficoTop5Actividad($reporte)],200);
    }

    public function formatoGaficoTop5Actividad($datos)
    {
        $respuesta = array();

        $respuesta[0] = ['Actividad','Quejas'];

        foreach ($datos as $key => $item)
        {
            $respuesta[$key+1] = [$item->actividad, (int)$item->cantidad];
        }

        return $respuesta;
    }

    public function graficoTop10(Request $request)
    {
        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'))->addDays(1);

        $this->validate($request, $rules);

        $reporte = DB::table('queja as q')
                        ->join('municipio as m','q.municipio_id','=','m.id')
                        ->select(DB::raw('COUNT(q.id) as cantidad'),'m.nombre as municipio')
                        ->whereBetween('q.created_at', [$desde, $hasta])
                        ->groupBy('m.nombre')
                        ->orderBy(DB::raw('COUNT(q.id)'),'desc')
                        ->take(10)
                        ->get();

        return response()->json(['data' => $this->formatoGaficoTop10($reporte)],200);
    }

    public function formatoGaficoTop10($datos)
    {
        $respuesta = array();

        $respuesta[0] = ['Municipio','Quejas'];

        foreach ($datos as $key => $item)
        {
            $respuesta[$key+1] = [$item->municipio, (int)$item->cantidad];
        }

        return $respuesta;
    }
}
