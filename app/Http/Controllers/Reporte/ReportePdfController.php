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
        $hasta = Carbon::parse($request->get('hasta'));

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
            /* $vista = \View::make('reportes.pdf-general',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->render();

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($vista);
            $pdf->setPaper('legal','landscape'); */

            //$pdf = \PDF::loadView('reportes.pdf-general',['registros' => $registros, 'desde' => $desde, 'hasta' => $hasta])->setPaper('legal','landscape');

            /* $pdf = \PDF::loadView('reportes.hola-pdf')->setPaper('legal','landscape');

            $fecha = Carbon::now()->format('dmY_h:m:s');

            return $pdf->download('reporte_'.$fecha.'.pdf'); */
            $pdf = \PDF::loadHTML('<h1>Test</h1>');
            return $pdf->download('prueba.pdf');
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }
}
