@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="container">
                <div class="card card-profile shadow-md">
                    <div class="img1"><img src="{{ asset('images/lake.jpg') }}" alt="back-image"></div>
                    <div class="img2"><img src="{{ asset('images/account.png') }}" alt="account"></div>
                    <div class="main-text">
                        <h2>{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</h2>
                        <div class="container">
                            <ul class="list-group">
                                <li class="list-group-item">Teléfono: {{ Auth::user()->telefono}}</li>
                                <li class="list-group-item">Correo electrónico: {{ Auth::user()->email}}</li>
                                <li class="list-group-item">Rol: {{ Auth::user()->rol->nombre}}</li>
                            </ul>
                            <div class="clearfix"></div>
                            <a class="btn btn-success btn-block" href="/perfil">Editar perfil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
