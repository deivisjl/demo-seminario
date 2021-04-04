<?php

namespace App\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function modificarAcceso()
    {
        return view('administrar.usuario.credencial');
    }
    public function actualizarAcceso(Request $request)
    {
        try
        {
            $rules = [
                'password'=>'required|string|min:5|confirmed',
            ];

            $this->validate($request,$rules);

            $registro = Auth::user();
            $registro->password = bcrypt($request->get('password'));
            $registro->save();

            return response()->json(['data' => 'Registro actualizado con éxito']);
        }
        catch (\Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function modificarPerfil(){
        $perfil['nombres'] = Auth::user()->nombres;
        $perfil['apellidos'] = Auth::user()->apellidos;
        $perfil['dpi'] = Auth::user()->dpi;
        $perfil['direccion'] = Auth::user()->direccion;
        $perfil['email'] = Auth::user()->email;
        $perfil['telefono'] = Auth::user()->telefono;

        return view('administrar.usuario.perfil',['perfil' => collect($perfil)]);
    }
    public function actualizarPerfil(Request $request){
        try
        {
            $rules = [
                'nombres' => 'required',
                'apellidos' => 'required',
                'dpi' => 'required|numeric|min:1',
                'telefono' => 'required|numeric|min:1',
                'direccion' => 'required',
            ];

            $this->validate($request, $rules);

            $perfil = Auth::user();
            $perfil->nombres = $request->get('nombres');
            $perfil->apellidos = $request->get('apellidos');
            $perfil->dpi = $request->get('dpi');
            $perfil->telefono = $request->get('telefono');
            $perfil->direccion = $request->get('direccion');
            $perfil->save();

            return response()->json(['data' => 'Registro actualizado con éxito'],200);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()],423);
        }
    }
}
