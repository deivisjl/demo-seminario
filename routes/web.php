<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false, 'reset' => false]);

Route::get('crear-queja','Queja\QuejaController@crearQueja');
Route::post('guardar-queja','Queja\QuejaController@guardarQueja');
Route::get('listado-municipios/{id}','Administrar\DepartamentoController@municipio');
Route::get('consultar-queja','Queja\QuejaController@consultarQueja');
Route::post('consultar-queja','Queja\QuejaController@detalleQueja');

Route::group(['middleware' =>['auth','admin']], function(){
    Route::resource('usuarios','Usuario\UsuarioController');
    Route::get('reportes-graficos','Reporte\ReporteController@index');

    Route::post('reporte-grafico-por-region','Reporte\ReporteController@graficoPorRegion');
    Route::post('reporte-grafico-por-departamento','Reporte\ReporteController@graficoPorDepartamento');
    Route::post('reporte-grafico-top5','Reporte\ReporteController@graficoTop5');
    Route::post('reporte-grafico-top5-actividad','Reporte\ReporteController@graficoTop5Actividad');
    Route::post('reporte-grafico-top10','Reporte\ReporteController@graficoTop10');
    Route::post('reporte-grafico-total-quejas','Reporte\ReporteController@graficoTotalQueja');

    Route::get('reportes-pdf','Reporte\ReportePdfController@index');
    Route::post('reporte-pdf-general','Reporte\ReportePdfController@reporteGeneral');
});

Route::group(['middleware' =>['auth','analista']], function(){

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('cambiar-credencial','Usuario\UsuarioController@modificarAcceso');
    Route::post('cambiar-credencial','Usuario\UsuarioController@actualizarAcceso');
    Route::get('perfil','Usuario\UsuarioController@modificarPerfil');
    Route::post('perfil','Usuario\UsuarioController@actualizarPerfil');

    Route::resource('regiones','Administrar\RegionController');
    Route::resource('departamentos','Administrar\DepartamentoController');
    Route::resource('municipios','Administrar\MunicipioController');
    Route::resource('actividad-economica','Administrar\ActividadEconomicaController');

    Route::resource('quejas','Queja\QuejaController');
    Route::post('procesar-queja','Queja\QuejaController@procesarQueja');
});


Route::get('prueba', function(){
    $registros = DB::table('queja as q')
            ->join('municipio as m','q.municipio_id','=','m.id')
            ->join('departamento as d','q.departamento_id','=', 'd.id')
            ->join('actividad_economica as ae','q.actividad_economica_id','=','ae.id')
            ->select('q.no as codigo','q.nit','q.negocio','m.nombre as municipio','d.nombre as departamento','ae.nombre as actividad','q.telefono_contacto','q.created_at')
            ->get();

            $fecha = \Carbon\Carbon::parse("23-04-2021");
            $pdf = \PDF::loadView('reportes.pdf-general',['registros' => $registros, 'desde' => $fecha, 'hasta' => $fecha])->setPaper('legal','landscape');

            return $pdf->download('reporte_'.$fecha.'.pdf');
});
