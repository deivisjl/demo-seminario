@extends('layouts.app')

@section('content')
<div id="loading"></div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-md">
                <div class="card-header">
                    <h3 class="card-title-custom">
                        Nuevo registro
                    </h3>
                    <div class="card-tools">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb-custom">
                              <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                              <li class="breadcrumb-item"><a href="/usuarios">Usuarios</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card-body">
                    <nuevo-usuario-component :roles="{{ $roles }}"></nuevo-usuario-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

