<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ $metaTitle ?? config('services.helper.alias_name', 'Diaco') }} - {{ config('app.name', 'Diaco') }} </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary sticky-top" style="box-shadow: 0 .125rem .25rem rgba(0,0,0,.150)!important;">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ $metaTitle === "Login" ? config('app.name', 'Laravel') : config('services.helper.app_alias','Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-tachometer-alt"></i> Administrar
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="{{ route('usuarios.index') }}"><i class="fas fa-users  icon-bg-verde"></i> Usuarios</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="{{ route('actividad-economica.index') }}"><i class="fas fa-clipboard  icon-bg-amarillo"></i> Actividad económica</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="{{ route('regiones.index') }}"><i class="fas fa-globe-americas icon-bg-azul"></i> Regiones</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="{{ route('departamentos.index') }}"><i class="fas fa-layer-group  icon-bg-rojo"></i> Departamentos</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="{{ route('municipios.index') }}"><i class="fas fa-street-view  icon-bg-violeta"></i> Municipios</a>
                            </div>
                          </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('quejas.index') }}"><i class="fas fa-address-book"></i> Quejas</a>
                          </li>
                          <li class="nav-item active">
                            <a class="nav-link" href="#"><i class="fas fa-chart-line"></i> Reportes</a>
                        </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                   <i class="fas fa-cog"></i> {{ Auth::user()->nombres }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/perfil">
                                        <i class="fas fa-user icon-bg-azul"></i> Perfil
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/cambiar-credencial">
                                        <i class="fas fa-key icon-bg-verde"></i> Cambiar contraseña
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt icon-bg-rojo"></i> Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    {{-- scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>
</html>
