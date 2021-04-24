@extends('layouts.app')

@section('content')
<div id="loading"></div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-md">
                <div class="card-header">
                    <h3 class="card-title-custom">
                        Detalle de queja
                    </h3>
                    <div class="card-tools">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb-custom">
                              <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                              <li class="breadcrumb-item"><a href="/historial-quejas">Historial de quejas</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Detalle de queja</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr class="text-center">
                            <th>Estado: {{ $registro['status'] }}</th>
                            <th>Usuario procesó: {{ $registro['usuario'] }}</th>
                        </tr>
                        <tr><th colspan="2">Datos del proveedor</th></tr>
                        <tr>
                            <td>NIT</td>
                            <td>{{ $registro['nit'] }}</td>
                        </tr>
                        <tr>
                            <td>Nombre</td>
                            <td>{{ $registro['negocio'] }}</td>
                        </tr>
                        <tr>
                            <td>Actividad económica</td>
                            <td>{{ $registro['actividad_economica'] }}</td>
                        </tr>
                        <tr>
                            <td>Municipio</td>
                            <td>{{ $registro['municipio'] }}</td>
                        </tr>
                        <tr>
                            <td>Departamento</td>
                            <td>{{ $registro['departamento'] }}</td>
                        </tr>
                        <tr><th>Datos del consumidor</th></td></tr>
                        <tr>
                            <td>Nacionalidad</td>
                            <td>{{ $registro['nacionalidad'] == 1 ? 'Guatemalteco' : 'Extranjero'  }}</td>
                        </tr>
                        <tr>
                            <td>Teléfono de contacto</td>
                            <td>{{ $registro['telefono_contacto'] }}</td>
                        </tr>
                        <tr>
                            <td>Correo de contacto</td>
                            <td>{{ $registro['correo_contacto'] }}</td>
                        </tr>
                        <tr>
                            <td>Nombre</td>
                            <td>{{ $registro['nombres'] }} {{ $registro['apellidos'] }}</td>
                        </tr>
                        <tr><th colspan="2">Detalle</th></tr>
                        <tr>
                            <td colspan="2">{{ $registro['detalle'] }}</td>
                        </tr>
                        <tr><th colspan="2">Solicitud</th></tr>
                        <tr>
                            <td colspan="2">{{ $registro['solicitud'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
