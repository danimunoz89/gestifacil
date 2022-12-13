<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="mapaweb bg-light border-4 rounded-3">
        <h3 class="card-header text-white bg-secondary fw-bold mb-3">MAPA WEB</h5>
            <div style="align: center; ">
                <ul>
                    <li><a href="{{ route('rutero_index') }}">Rutero</a><br></li>
                    @role("Administrador")
                    <li><a href="#">Usuarios</a><br></li>
                    <li>
                        
                        <ul>
                            <li><a href="{{ route('usuario_index') }}">Listado Usuarios</a><br></li>
                            <li><a href="{{ route('usuario_crear') }}">Crear Usuario</a><br></li>
                        </ul>
                        @endrole
                    </li>
                    <li><a href="#">Clientes</a><br></li>
                    <li>
                        <ul>
                            <li><a href="{{ route('cliente_index') }}">Listado Clientes</a><br></li>
                            @role("Administrador")
                            <li><a href="{{ route('cliente_crear') }}">Crear Cliente</a><br></li>
                            @endrole
                        </ul>
                    </li>
                    @role("Administrador")
                    <li><a href="#">Categorias</a><br></li>
                    <li>
                        <ul>
                            <li><a href="{{ route('categoria_index') }}">Listado Categorias</a><br></li>
                            <li><a href="{{ route('categoria_crear') }}">Crear Categoria</a><br></li>
                        </ul>
                    </li>
                    @endrole
                    <li><a href="#">Productos</a><br></li>
                    <li>
                        <ul>
                            <li><a href="{{ route('producto_index') }}">Listado Productos</a><br></li>
                            @role("Administrador")
                            <li><a href="{{ route('producto_crear') }}">Crear Producto</a><br></li>
                            @endrole
                        </ul>
                    </li>
                    <li><a href="#">Pedidos</a><br></li>
                    <li>
                        <ul>
                            <li><a href="{{ route('pedidos_index') }}">Listado Pedidos</a><br></li>
                            <li><a href="{{ route('pedido_crear') }}">Crear Pedido</a><br></li>
                        </ul>
                    </li>
                    <li><a href="#">Enlaces de Interés </a><br></li>
                    <li>
                        <ul>
                            <li><a href="{{ route('enlaces_sobrenosotros') }}">Sobre Nosotros</a><br></li>
                            <li><a href="{{ route('enlaces_politicaprivacidad') }}">Política de Privacidad</a><br></li>
                            <li><a href="{{ route('enlaces_mapaweb') }}">Mapa Web</a><br></li>
                        </ul>
                    </li>
                </ul>
            </div>
    </div>
@endsection
