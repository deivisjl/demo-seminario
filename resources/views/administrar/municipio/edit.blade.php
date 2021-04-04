@extends('layouts.app')

@section('content')
<div id="loading"></div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-md">
                <div class="card-header">
                    <h3 class="card-title-custom">
                        Editar municipio
                    </h3>
                    <div class="card-tools">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb-custom">
                              <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                              <li class="breadcrumb-item"><a href="/municipios">Municipios</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Editar</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card-body">
                    <editar-municipio-component :departamentos="{{ $departamentos }}" :municipio="{{ $municipio }}"></editar-municipio-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

