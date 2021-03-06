<?php

namespace App\Http\Controllers\Reporte;

use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class ReportePdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reportes.pdf');
    }

    public function reporteGeneral(Request $request)
    {
        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'))->addDays(1);

        $this->validate($request, $rules);

        try
        {
            $registros = DB::table('queja as q')
                        ->join('municipio as m','q.municipio_id','=','m.id')
                        ->join('departamento as d','q.departamento_id','=', 'd.id')
                        ->join('actividad_economica as ae','q.actividad_economica_id','=','ae.id')
                        ->select('q.no as codigo','q.nit','q.negocio','m.nombre as municipio','d.nombre as departamento','ae.nombre as actividad','q.telefono_contacto','q.created_at')
                        ->whereBetween('q.created_at',[$desde, $hasta])
                        ->get();

            $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                    ->loadView('reportes.pdf-general',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('legal','landscape');

            $fecha = Carbon::now()->format('dmY_h:m:s');

            return $pdf->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function reporteMunicipio(Request $request)
    {
        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'))->addDays(1);

        $this->validate($request, $rules);

        try
        {
            $registros = DB::table('queja as q')
                        ->join('municipio as m','q.municipio_id','=','m.id')
                        ->join('departamento as d','q.departamento_id','=', 'd.id')
                        ->select(DB::raw('COUNT(q.id) as cantidad'),'m.nombre as municipio','d.nombre as departamento')
                        ->whereBetween('q.created_at',[$desde, $hasta])
                        ->groupBy('m.nombre','d.nombre')
                        ->orderBy('m.nombre','asc')
                        ->get();

            $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                    ->loadView('reportes.pdf-municipio',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('letter','portrait');

            $fecha = Carbon::now()->format('dmY_h:m:s');

            return $pdf->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function reporteNegocio(Request $request)
    {
        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'))->addDays(1);

        $this->validate($request, $rules);

        try
        {
            $registros = DB::table('queja as q')
                        ->join('municipio as m','q.municipio_id','=','m.id')
                        ->join('departamento as d','q.departamento_id','=', 'd.id')
                        ->select(DB::raw('COUNT(q.nit) as cantidad'),'q.negocio','q.nit','q.direccion','m.nombre as municipio','d.nombre as departamento')
                        ->whereBetween('q.created_at',[$desde, $hasta])
                        ->groupBy('q.negocio','q.nit','q.direccion','m.nombre','d.nombre')
                        ->orderBy('q.negocio','asc')
                        ->get();

            $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                    ->loadView('reportes.pdf-negocio',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('legal','landscape');

            $fecha = Carbon::now()->format('dmY_h:m:s');

            return $pdf->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function reporteActividad(Request $request)
    {
        $rules = [
            'desde'=>'required|date',
            'hasta'=>'required|date'
        ];

        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'))->addDays(1);

        $this->validate($request, $rules);

        try
        {
            $registros = DB::table('queja as q')
                        ->join('actividad_economica as ae','q.actividad_economica_id','ae.id')
                        ->select(DB::raw('COUNT(q.id) as cantidad'),'ae.nombre as actividad')
                        ->whereBetween('q.created_at',[$desde, $hasta])
                        ->groupBy('ae.nombre')
                        ->orderBy('ae.nombre','asc')
                        ->get();

            $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                    ->loadView('reportes.pdf-actividad',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('letter','portrait');

            $fecha = Carbon::now()->format('dmY_h:m:s');

            return $pdf->download('reporte_'.$fecha.'.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }
}
