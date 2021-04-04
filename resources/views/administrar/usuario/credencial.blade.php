@extends('layouts.app')

@section('content')
<div id="loading"></div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-md">
                <div class="card-header">
                    <h3 class="card-title-custom">
                        Cambiar contraseña
                    </h3>
                    <div class="card-tools">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb-custom">
                              <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Cambiar credencial</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card-body">
                    <credencial-component></credencial-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

