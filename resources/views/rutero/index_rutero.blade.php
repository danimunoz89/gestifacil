<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="table-responsive py-4 maincontent">

        <div class="container-fluid">
            <form method="GET" action="{{ route('rutero_index') }}" class="row g-3">
                <div class="col-md-8 form-group m-auto mb-2">
                    <input type="date" id="date" name="date" class="form-control text-muted text-center"
                        value="{{ $searchValue }}">
                </div>
                <div class="col-md-2 form-group m-auto mb-2 text-center">
                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
            </form>
        </div>

        <hr class="hr hr-blurry" />

        <div class="container-fluid">
            <div class="map" id="mapid"></div>

            <hr class="hr hr-blurry" />

            <table class="table table-light table-hover border border-5 rounded">

                <thead class="tablehead text-center align-middle text-uppercase">
                    <tr>
                        <th>Local</th>
                        <th>Dirección</th>
                        <th>Localidad</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>Ficha</th>
                        <th>Enrutar</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($clients as $client)
                        <tr class="tablecells text-center align-middle fw-light">
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->address }}</td>
                            <td>{{ $client->town }}</td>
                            <td>{{ $client->owner }}</td>
                            <td>{{ $client->phone }}</td>
                            <td>
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-sheet-{{ $client->id }}"><img class="picto"
                                        src="/img/gestifacil/ficha.png" /></a>
                            </td>
                            <td>
                                <a href="{{ route('dia_editar', $client->id) }}"><img class="picto"
                                        src="/img/gestifacil/enrutar.png" /></a>
                            </td>
                        </tr>
                        @include('clientes/ficha')
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
                {{ $clients->onEachSide(3)->links() }}
            </div>
        </div>

        <script>
        //Recojo en json el listado de las latitudes, longitudes y nombres
        //de los clientes para un día seleccionado y poder recorrerlos en el script
        //que se carga a continuación y poder pintarlos en el mapa.
            var longitudes = {!! json_encode($longitudes) !!};
            var latitudes = {!! json_encode($latitudes) !!};
            var names = {!! json_encode($names) !!};
        </script>
    
        <script src="{{ asset('js/rutero/rutero_index.js') }}"></script>
    @endsection
