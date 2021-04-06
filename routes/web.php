<?php

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

Route::group(['middleware' =>['auth']], function(){

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('usuarios','Usuario\UsuarioController');
    Route::get('cambiar-credencial','Usuario\UsuarioController@modificarAcceso');
    Route::post('cambiar-credencial','Usuario\UsuarioController@actualizarAcceso');
    Route::get('perfil','Usuario\UsuarioController@modificarPerfil');
    Route::post('perfil','Usuario\UsuarioController@actualizarPerfil');

    Route::resource('regiones','Administrar\RegionController');
    Route::resource('departamentos','Administrar\DepartamentoController');
    Route::resource('municipios','Administrar\MunicipioController');
    Route::resource('actividad-economica','Administrar\ActividadEconomicaController');

    Route::resource('quejas','Queja\QuejaController');
});

