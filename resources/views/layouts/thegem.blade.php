<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Raleway:wght@400;700;900&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Crear queja</a></li>
                            <li><a href="#">Consultar queja</a></li>
                            <li><a href="#">Acerca de</a></li>
                            <li><a href="#" class="boton boton-primario">Iniciar sesion</a></li>
                        </ul>
                    </nav>
                </div><!-- Barra de navegacion -->

                <div class="tagline">
                    <h1>DIACO</h1>
                    <p>La DIACO procurará que las relaciones entre proveedores, consumidores y usuarios se lleven a cabo con apego a la Leyes en materia de Protección al Consumidor.</p>
                </div>
            </div>
        </header>
        <section id="soluciones">
            <div class="azul bienvenida  text-center seccion">
                <h2 class="texto-blanco">Dirección de Atención y Asistencia al Consumidor</h2>
                <div class="contenedor">
                    <h5 class="texto-blanco">La Dirección de Atención y Asistencia al Consumidor (DIACO) fue creada como dependencia del Ministerio de Economía según el Acuerdo Gubernativo No. 425-95 de fecha 4 de septiembre de 1995. Actualmente la DIACO tiene la responsabilidad de defender los derechos de los consumidores y usuarios. El Congreso de la República de Guatemala aprobó el Decreto Ley 006-2003 "Ley de Protección al Consumidor y Usuario", habiendo sido publicado en el Diario de Centro América el día 11 de marzo del año 2003, entró en vigencia el 26 de Marzo del 2003. El objeto de la Ley es la de promover, divulgar y defender los derechos de los consumidores y usuarios</h5>
                </div>
            </div>
        </section>
        <section class="bienvenida text-center seccion">
            <h2 class="texto-primario">Bienvenido a la pagina de la DIACO</h2>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque molestias, a eius, numquam sint obcaecati cumque aliquid doloremque placeat optio, eaque corporis doloribus perferendis dolore hic tempora similique cupiditate. Sunt?</p>
        </section>
        <div class="contenedor">

        </div>
        <footer class="site-footer contenedor">
            <hr>
            <div class="contenido-footer">
                <nav class="menu-principal">
                    <ul class="menu">
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Crear queja</a></li>
                        <li><a href="#">Consultar queja</a></li>
                        <li><a href="#">Acerca de</a></li>
                    </ul>
                </nav>
                <p class="copyright">Todos los derechos reservados DIACO 2021</p>
            </div>
        </footer>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
