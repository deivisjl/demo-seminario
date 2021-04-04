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

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('usuarios','Usuario\UsuarioController');
Route::get('cambiar-credencial','Usuario\UsuarioController@modificarAcceso');
Route::post('cambiar-credencial','Usuario\UsuarioController@actualizarAcceso');
Route::get('perfil','Usuario\UsuarioController@modificarPerfil');
Route::post('perfil','Usuario\UsuarioController@actualizarPerfil');

Route::resource('regiones','Administrar\RegionController');
Route::resource('departamentos','Administrar\DepartamentoController');
Route::resource('municipios','Administrar\MunicipioController');
