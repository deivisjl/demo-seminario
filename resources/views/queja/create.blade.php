@extends('layouts.queja')

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
                              <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Nueva queja</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card-body">
                    <queja-component :departamentos="{{ $departamentos }}" :actividades="{{ $actividades }}"></queja-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


