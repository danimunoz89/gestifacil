<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS Normalización Estilos-->
    <link rel="stylesheet"href="{{ asset('css/normalize.css') }}">
    <!--CDN Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--CSS Proyecto Gestifacil-->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <!--CDN Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--CDN leaflet para carga de mapas-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
    <title>GESTIFACIL</title>
</head>

<body class="body">

    <!--Header-->
    <header class="header">
        <a href="{{ route('inicio_login') }}" class="header__logo">
            <img src="{{ asset('img/gestifacil/logo.png') }}" class="logo" alt="logoGestifacil" title="Inicio">
        </a>
    </header>

    <!--Nav-->
    <!--Con hasanyrole y role consigo deshabilitar el acceso a los usuarios que no tengan los roles señalados-->
    @hasanyrole('Administrador|Usuario')
        <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light float-center">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rutero_index') }}">RUTERO</a>
                        </li>
                        @role('Administrador')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    USUARIOS
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('usuario_index') }}">LISTADO USUARIOS</a></li>
                                    <li><a class="dropdown-item" href="{{ route('usuario_crear') }}">CREAR USUARIO</a></li>
                                </ul>
                            </li>
                        @endrole
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                CLIENTES
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('cliente_index') }}">LISTADO CLIENTES</a></li>
                                <li><a class="dropdown-item" href="{{ route('cliente_crear') }}">CREAR CLIENTE</a></li>
                            </ul>
                        </li>
                        @role('Administrador')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    CATEGORIAS
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('categoria_index') }}">LISTADO CATEGORIAS</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('categoria_crear') }}">CREAR CATEGORIA</a></li>
                                </ul>
                            </li>
                        @endrole
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                PRODUCTOS
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('producto_index') }}">LISTADO PRODUCTOS</a>
                                </li>
                                @role('Administrador')
                                    <li><a class="dropdown-item" href="{{ route('producto_crear') }}">CREAR PRODUCTO</a></li>
                                @endrole
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                PEDIDOS
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('pedidos_index') }}">LISTADO PEDIDOS</a></li>
                                <li><a class="dropdown-item" href="{{ route('pedido_crear') }}">CREAR PEDIDO </a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-uppercase" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ session('name') }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('usuario_desconexion') }}">DESCONEXIÓN</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endhasanyrole

    <!--Contenido Central-->
    <div class="main">
        <!--Parte Principal-->
        <div class="main__content">
            <article class=main__content_articulo>
                
                <!--yield permite "insertar" en la plantilla los distintos blades que hagan una llamada a plantilla.blade.php
                con extends y con content('contenidoPrincipal').
                De este modo se evita así tener que estar escribiendo constantemente todo el código HTML,
                pues todas las plantillas blade del proyecto comparten la misma estructura-->
                @yield('contenidoPrincipal')

            </article>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">

                <div class="col-sm-12 col-md-6">
                    <h2>GESTIFACIL</h2>
                    <p class="text-justify">TU PROGRAMA DE VENTAS PARA EL DÍA A DÍA.</p>
                </div>

                <div class="col-xs-6 col-md-3">
                    @hasanyrole('Administrador|Usuario')
                        <h2>Acceso Rápido</h2>
                        <ul class="enlacesFooter">
                            <li><a href="{{ route('rutero_index') }}">Rutero</a></li>
                            <li><a href="{{ route('cliente_index') }}">Listado Clientes</a></li>
                            <li><a href="{{ route('producto_index') }}">Listado Productos</a></li>
                            <li><a href="{{ route('pedidos_index') }}">Listado Pedidos</a></li>
                        </ul>
                    @endhasanyrole
                </div>

                <div class="col-xs-6 col-md-3">
                    <h2>Enlaces de Interés</h2>
                    <ul class="enlacesFooter">
                        <li><a href="{{ route('enlaces_sobrenosotros') }}">Sobre Nosotros</a></li>
                        <li><a href="{{ route('enlaces_politicaprivacidad') }}">Política de Privacidad</a></li>
                        @hasanyrole('Administrador|Usuario')
                            <li><a href="{{ route('enlaces_mapaweb') }}">Mapa Web</a></li>
                        @endhasanyrole
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="container">
            <div class="redesSociales">
                <a href="mailto:daniel.munozlopez@outlook.com"><img src="{{ asset('img/gestifacil/mail.png') }}"
                        class="img" alt="mail" title="email"></a>
                <a href="https://www.twitter.com"><img src="{{ asset('img/gestifacil/twitter.png') }}"
                        class="img" alt="twitter" title="twitter"></a>
                <a href="https://www.instagram.com"><img src="{{ asset('img/gestifacil/instagram.png') }}"
                        class="img" alt="instagram" title="instagram"></a>
            </div>
            <div class="row">
                <div>
                    <p class="copyright"> Daniel Muñoz López - TFG 2º DAW IES Maestre Calatrava (Ciudad Real)</p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
