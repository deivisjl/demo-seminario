<?php

namespace App\Http\Controllers\Queja;

use App\Queja;
use App\Departamento;
use App\ActividadEconomica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class QuejaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(Queja $queja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Queja  $queja
     * @return \Illuminate\Http\Response
     */
    public function edit(Queja $queja)
    {
        //
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
                'telefono' => 'nullable|numeric',
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
                ->select('q.no_documento','q.fecha_documento','q.nit','q.negocio','q.direccion','ae.nombre as actividad','d.nombre as departamento','m.nombre as municipio','q.detalle','q.solicitud','q.created_at')
                ->where('q.no',$request->get('no'))
                ->first();

        return response()->json(['data' => $queja],200);
    }

    private function generarIdQueja(Queja $queja)
    {
        if($queja->id < 10)
        {
            $queja->no = $queja->id.'0000000'.$this->baseIdQueja();
        }
        else if($queja->id >= 10 && $queja->id < 100)
        {
            $queja->no = $queja->id.'000000'.$this->baseIdQueja();
        }
        else if($queja->id >= 100 && $queja->id < 1000)
        {
            $queja->no = $queja->id.'00000'.$this->baseIdQueja();
        }
        else if($queja->id >= 1000 && $queja->id < 10000)
        {
            $queja->no = $queja->id.'0000'.$this->baseIdQueja();
        }
        else if($queja->id >= 10000 && $queja->id < 100000)
        {
            $queja->no = $queja->id.'000'.$this->baseIdQueja();
        }
        else if($queja->id >= 100000 && $queja->id < 1000000)
        {
            $queja->no = $queja->id.'00'.$this->baseIdQueja();
        }
        else if($queja->id >= 1000000 && $queja->id < 10000000)
        {
            $queja->no = $queja->id.'0'.$this->baseIdQueja();
        }

        $queja->save();
        return $queja;
    }

    private function baseIdQueja()
    {
        return \Carbon\Carbon::now()->format('Y');
    }
}

