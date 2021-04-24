<?php

namespace App\Http\Controllers\Queja;

use App\Queja;
use App\Departamento;
use App\ActividadEconomica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuejaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('queja.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Queja  $queja
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("q.id","q.no","q.nit","q.negocio","ae.nombre");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $quejas = DB::table('queja as q')
                ->join('actividad_economica as ae','q.actividad_economica_id','ae.id')
                ->select('q.id','q.no','q.negocio','q.nit','ae.nombre as actividad','q.status')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->where('q.status','!=','Procesado')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count =  DB::table('queja as q')
                ->join('actividad_economica as ae','q.actividad_economica_id','ae.id')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->where('q.status','!=','Procesado')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $quejas,
            );
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Queja  $queja
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $registro = DB::table('queja as q')
                        ->join('actividad_economica as ae','q.actividad_economica_id','=','ae.id')
                        ->join('departamento as d','q.departamento_id','=','d.id')
                        ->join('municipio as m','q.municipio_id','=','m.id')
                        ->select('q.no','q.nacionalidad','q.no_documento','q.fecha_documento','q.detalle','q.solicitud','q.telefono_contacto','q.correo_contacto','q.nombres','q.apellidos','q.nit','q.negocio','q.direccion','q.status','ae.nombre as actividad_economica','d.nombre as departamento','m.nombre as municipio')
                        ->where('no',$id)
                        ->where('status','!=',Queja::QUEJA_PROCESADA)
                        ->first();
        if(!$registro)
        {
            abort(404);
        }
        return view('queja.detalle',['registro' => collect($registro)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Queja  $queja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Queja $queja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Queja  $queja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Queja $queja)
    {
        //
    }

    public function crearQueja()
    {
        $departamentos = Departamento::orderBy('nombre','asc')->get();
        $actividades = ActividadEconomica::orderBy('nombre','asc')->get();

        return view('queja.create',['departamentos' => $departamentos, 'actividades' => $actividades]);
    }

    public function guardarQueja(Request $request)
    {
        try
        {
            $rules = [
                'actividad' => 'required|numeric',
                'correo' => 'nullable|email',
                'departamento' => 'required|numeric',
                'detalle' => 'required|string',
                'documento' => 'nullable|string',//
                'fecha' => 'required|date',
                'municipio' => 'required|numeric',
                'negocio' => 'nullable|string',
                'nit' => 'required|string',
                'origen' => 'required|numeric|min:1|max:2',
                'solicitud' => 'required|string',
                'telefono' => 'required|numeric',
                'nombres' => 'required',
                'apellidos' => 'required',
                'direccion' => 'required|string'
            ];

            $this->validate($request, $rules);

            $queja = new Queja();
            $queja->no_documento = $request->get('documento');
            $queja->fecha_documento = $request->get('fecha');
            $queja->detalle = $request->get('detalle');
            $queja->solicitud = $request->get('solicitud');
            $queja->nacionalidad = $request->get('origen');
            $queja->telefono_contacto = $request->get('telefono');
            $queja->correo_contacto = $request->get('correo');
            $queja->nombres = $request->get('nombres');
            $queja->apellidos = $request->get('apellidos');
            $queja->nit = $request->get('nit');
            $queja->negocio = $request->get('negocio');
            $queja->direccion = $request->get('direccion');
            $queja->ip = $request->ip();
            $queja->actividad_economica_id = $request->get('actividad');
            $queja->departamento_id = $request->get('departamento');
            $queja->municipio_id = $request->get('municipio');
            $queja->save();

            $queja = $this->generarIdQueja($queja);

            return response()->json(['data' => 'Registro generado con éxito','registro' => $queja],200);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()],423);
        }
    }

    public function consultarQueja()
    {
        return view('queja.consultar');
    }

    public function detalleQueja(Request $request)
    {
        $queja = DB::table('queja as q')
                ->join('municipio as m','q.municipio_id','m.id')
                ->join('departamento as d','q.departamento_id','d.id')
                ->join('actividad_economica as ae','q.actividad_economica_id','ae.id')
                ->select('q.no_documento','q.fecha_documento','q.nit','q.negocio','q.direccion','q.status','ae.nombre as actividad','d.nombre as departamento','m.nombre as municipio','q.detalle','q.solicitud','q.created_at')
                ->where('q.no',$request->get('no'))
                ->first();

        return response()->json(['data' => $queja],200);
    }

    public function procesarQueja(Request $request)
    {
        $queja = Queja::where('no',$request->get('no'))->first();
        $queja->status = QUEJA::QUEJA_PROCESADA;
        $queja->usuario_proceso_id = Auth::user()->id;
        $queja->save();

        return response()->json(['data' => 'Registro actualizado con éxito'], 200);
    }

    private function generarIdQueja(Queja $queja)
    {
        $queja->no = $this->baseIdQueja().'0'.$queja->id;

        $queja->save();
        return $queja;
    }

    private function baseIdQueja()
    {
        return \Carbon\Carbon::now()->format('Y');
    }
}

