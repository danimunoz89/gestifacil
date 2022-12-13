<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="table-responsive py-4 maincontent">

        <div class="container-fluid">
            <form method="get" action="{{ route('usuario_index') }}" class="row g-3">
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="text" id="dni" name="dni" class="form-control text-center"
                        placeholder="Introduce DNI">
                </div>
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="text" id="name" name="name" class="form-control text-center"
                        placeholder="Introduce Nombre">
                </div>
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="text" id="lastname" name="lastname" class="form-control text-center"
                        placeholder="Introduce Apellidos">
                </div>
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="text" id="phone" name="phone" class="form-control text-center"
                        placeholder="Introduce Teléfono">
                </div>
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="text" id="email" name="email" class="form-control text-center"
                        placeholder="Introduce Email">
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
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th colspan="2">Editar/Borrar</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr class="tablecells text-center align-middle fw-light">
                        <td>{{ $user->dni }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <!--Con role consigo deshabilitar el acceso a los usuarios que no tengan los roles señalados-->
                        @role('Administrador')
                            @if ($user->dni != 000000000)
                                <td>
                                    <a href="{{ route('usuario_editar', $user->id) }}"><img class="picto"
                                            src="/img/gestifacil/editar.png" /></a>
                                </td>
                                <td>
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal-delete-{{ $user->id }}"><img class="picto"
                                            src="/img/gestifacil/eliminar.png" /></a>
                                </td>
                            @else
                                <td colspan="2">
                                    <a href="{{ route('usuario_editar', $user->id) }}"><img class="picto"
                                            src="/img/gestifacil/editar.png" /></a>
                                </td>
                            @endif
                        @endrole
                    </tr>
                    @include('usuarios/eliminar')
                @empty
                    <tr>
                        <th class="tablehead text-center" colspan="7">No hay registros</th>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <hr class="hr hr-blurry" />
        
        <!--Permite el paginador de datos-->
        <div class="d-flex justify-content-center">
            {{ $users->onEachSide(3)->links() }}
        </div>
    @endsection
