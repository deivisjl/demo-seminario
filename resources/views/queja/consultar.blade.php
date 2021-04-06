@extends('layouts.queja')

@section('content')
<div id="loading"></div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-md">
                <div class="card-header">
                    <h3 class="card-title-custom">
                        Consultar queja
                    </h3>
                    <div class="card-tools">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb-custom">
                              <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Consultar queja</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card-body">
                    <consulta-queja-component></consulta-queja-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


