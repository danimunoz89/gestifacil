<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="table-responsive py-4 maincontent">

        <div class="container-fluid">
            <form method="get" action="{{ route('cliente_index') }}" class="row g-3">
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="text" id="name" name="name" class="form-control text-center"
                        placeholder="Introduce Cliente">
                </div>
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="text" id="town" name="town" class="form-control text-center"
                        placeholder="Introduce Localidad">
                </div>
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="text" id="phone" name="phone" class="form-control text-center"
                        placeholder="Introduce Teléfono">
                </div>
                <div class="col-md-6 form-group m-auto mb-2">
                    <select class="form-select form-select-md text-center text-muted" id="userid" name="userid">
                        <option value="">Selecciona un comercial</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->dni }} - {{ $user->name }}
                                {{ $user->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group text-center m-auto">
                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                </div>
            </form>
        </div>

        <hr class="hr hr-blurry" />

        <table class="table table-light table-hover border border-5 rounded">

            <thead class="tablehead text-center align-middle text-uppercase">
                <tr>
                    <th>Cliente</th>
                    <th>Localidad</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Ficha</th>
                    <th>Enrutar</th>
                    <!--Con role consigo deshabilitar el acceso a los usuarios que no tengan los roles señalados-->
                    @role('Usuario')
                    <th colspan="2">Editar</th>
                    @endrole
                    @role('Administrador')
                    <th colspan="2">Editar/Borrar</th>
                    @endrole
                </tr>
            </thead>

            <tbody>
                @forelse ($clients as $client)
                    <tr class="tablecells text-center align-middle fw-light">
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->town }}</td>
                        <td>{{ $client->owner }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->email }}</td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-sheet-{{ $client->id }}"><img
                                    class="picto" src="/img/gestifacil/ficha.png" /></a>
                        </td>
                        <td>
                            <a href="{{ route('dia_editar', $client->id) }}"><img class="picto"
                                    src="/img/gestifacil/enrutar.png" /></a>
                        </td>
                            <td>
                                <a href="{{ route('cliente_editar', $client->id) }}"><img class="picto"
                                        src="/img/gestifacil/editar.png" /></a>
                            </td>
                        @role('Administrador')
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $client->id }}"><img
                                        class="picto" src="/img/gestifacil/eliminar.png" /></a>
                            </td>
                        @endrole
                    </tr>
                    @include('clientes/ficha')
                    @include('clientes/eliminar')
                @empty
                    <tr>
                        <th class="tablehead text-center" colspan="9">No hay registros</th>
                    </tr>
                @endforelse


            </tbody>
        </table>

        <hr class="hr hr-blurry" />

        <!--Permite el paginador de datos-->
        <div class="d-flex justify-content-center">
            {{ $clients->onEachSide(3)->links() }}
        </div>
    </div>
@endsection
