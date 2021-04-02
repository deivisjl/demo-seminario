<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ $metaTitle ?? config('app.name', 'Diaco') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Raleway:wght@400;700;900&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body class="home">
    <div id="app" class="home">
        <header class="site-header">
            <div class="contenedor header-grid">
                <div class="barra-navegacion">
                    <div class="logo">
                        <img src="img/diaco-logo.png" alt="logo" style="height: 65px;">
                    </div>
                    <nav class="menu-principal">
                        <ul class="menu">
                            <li><a href="/">Inicio</a></li>
                            <li><a href="#">Crear queja</a></li>
                            <li><a href="#">Consultar queja</a></li>
                            <li><a href="#">Acerca de</a></li>
                            <li><a href="/login" class="boton boton-primario">Iniciar sesion</a></li>
                        </ul>
                    </nav>
                </div><!-- Barra de navegacion -->

                <div class="tagline">
                    <h1>DIACO</h1>
                    <p>La DIACO procurará que las relaciones entre proveedores, consumidores y usuarios se lleven a cabo con apego a las Leyes en materia de Protección al Consumidor.</p>
                </div>
            </div>
        </header>

        <main class="py-4">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>
    <script src="{{ asset('js/landing.js') }}" defer></script>
</body>
</html>
