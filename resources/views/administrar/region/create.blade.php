@extends('layouts.app')

@section('content')
<div id="loading"></div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-md">
                <div class="card-header">
                    <h3 class="card-title-custom">
                        Nuevo registro
                    </h3>
                    <div class="card-tools">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb-custom">
                              <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                              <li class="breadcrumb-item"><a href="/regiones">Regiones</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Nueva</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card-body">
                    <nuevo-region-component></nuevo-region-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

