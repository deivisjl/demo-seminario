<?php

namespace App\Http\Controllers\Usuario;

use App\Rol;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.usuario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Rol::all();

        return view('administrar.usuario.create',['roles' => $roles]);
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
                'nombres' => 'required',
                'apellidos' => 'required',
                'dpi' => 'required|numeric|min:1',
                'telefono' => 'required|numeric|min:1',
                'direccion' => 'required',
                'rol' => 'required|numeric|min:1',
                'email'=>'required|unique:users',
                'password'=>'required|string|min:5|confirmed',
            ];

            $this->validate($request, $rules);

            $usuario = new User();
            $usuario->nombres = $request->get('nombres');
            $usuario->apellidos = $request->get('apellidos');
            $usuario->dpi = $request->get('dpi');
            $usuario->telefono = $request->get('telefono');
            $usuario->direccion = $request->get('direccion');
            $usuario->rol_id = $request->get('rol');
            $usuario->email = $request->get('email');
            $usuario->password = bcrypt($request->get('password'));
            $usuario->save();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("u.id","u.nombres","u.apellidos","u.email","r.nombre","u.telefono");

        $columna = $request['order'][0]["column"];

        $criterio = $request['search']['value'];

        $usuarios = DB::table('users as u')
                ->join('rol as r','u.rol_id','r.id')
                ->select('u.id','u.nombres','u.apellidos', 'u.email', 'r.nombre as rol','u.telefono')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->whereNull('u.deleted_at')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();

        $count = DB::table('users as u')
                ->join('rol as r','u.rol_id','r.id')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->whereNull('u.deleted_at')
                ->count();

        $data = array(
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $usuarios,
            );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Rol::all();

        $usuario = User::findOrFail($id);

        return view('administrar.usuario.edit',['usuario' => $usuario,'roles' => $roles]);
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
        try
        {
            $rules = [
                'nombres' => 'required',
                'apellidos' => 'required',
                'dpi' => 'required|numeric|min:1',
                'telefono' => 'required|numeric|min:1',
                'direccion' => 'required',
                'rol' => 'required|numeric|min:1',
            ];

            $this->validate($request, $rules);

            $usuario = User::findOrFail($id);
            $usuario->nombres = $request->get('nombres');
            $usuario->apellidos = $request->get('apellidos');
            $usuario->dpi = $request->get('dpi');
            $usuario->telefono = $request->get('telefono');
            $usuario->direccion = $request->get('direccion');
            $usuario->rol_id = $request->get('rol');
            $usuario->save();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {

            $usuario = User::FindOrFail($id);

            if($usuario->id == Auth::user()->id)
            {
                throw new \Exception("No se puede eliminar el usuario que está en sesión");
            }
            $usuario->delete();

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
