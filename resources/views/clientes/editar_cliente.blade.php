<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="forms bg-light border border-4 rounded-3">
        <h5 class="card-header text-white bg-secondary fw-bold">EDITAR CLIENTE</h5>
        <div class="card-body">
            <form method="post" action="{{ route('cliente_actualizar', $client->id) }}" class="row g-3">
                <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
                     y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
                    que se envían entre cliente y servidor-->                
                @csrf
                <div class="col-md-6 form-group">
                    <label for="iduser" class="titleField">Selecciona un comercial</label>
                    <br>
                    <select class="form-select form-select-md mb-3" name="iduser" id="iduser">
                        <option value="0">Selecciona un comercial</option>
                        @foreach ($users as $user)
                            @if ($user->id == $client->id_user)
                                <option selected value="{{ $user->id }}">{{ $user->dni }} - {{ $user->name }}
                                    {{ $user->lastname }}</option>
                            @else
                                <option value="{{ $user->id }}">{{ $user->dni }} - {{ $user->name }}
                                    {{ $user->lastname }}</option>
                            @endif
                        @endforeach
                    </select>
                    <!--Mensaje error formulario validación servidor -->
                    @error('iduser')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verificationSelect" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="name" class="titleField">Nombre del local</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Local"
                        value="{{ $client->name }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="cif" class="titleField">CIF</label>
                    <input type="text" id="cif" name="cif" class="form-control" placeholder="Ej: B12345678"
                        value="{{ $client->cif }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('cif')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="email" class="titleField">Email</label>
                    <input type="text" id="email" name="email" class="form-control"
                        placeholder="ejemplo@ejemplo.com" value="{{ $client->email }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="phone" class="titleField">Teléfono 1</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Ej: 926926926"
                        value="{{ $client->phone }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="zip" class="titleField">Código Postal</label>
                    <input type="text" id="zip" name="zip" class="form-control" placeholder="Ej: 13000"
                        value="{{ $client->zip }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('zip')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="address" class="titleField">Dirección</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Dirección"
                        value="{{ $client->address }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="town" class="titleField">Localidad</label>
                    <input type="text" id="town" name="town" class="form-control" placeholder="Localidad"
                        value="{{ $client->town }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('town')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="province" class="titleField">Provincia</label>
                    <input type="text" id="province" name="province" placeholder="Provincia" class="form-control"
                        value="{{ $client->province }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('province')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="owner" class="titleField">Dueño/Responsable</label>
                    <input type="text" id="owner" name="owner" class="form-control"
                        placeholder="Dueño/Responsable" value="{{ $client->owner }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('owner')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="longitude" class="titleField">Longitud</label>
                    <input type="text" id="longitude" name="longitude" class="form-control"
                        value="{{ $client->longitude }}" readonly>
                </div>
                <div class="col-md-6 form-group">
                    <label for="latitude" class="titleField">Latitud</label>
                    <input type="text" id="latitude" name="latitude" class="form-control"
                        value="{{ $client->latitude }}" readonly>
                </div>
                <!--Campo oculto que utilizo para recoger el día de visita actual para que cuando actualice
                el cliente este no torne a NULL en la BBDD -->
                <input type="hidden" id="visit_date" name="visit_date" value="{{ $client->visit_date }}" />
                <div class="row-md-6 form-group">
                    <label for="visit_date" class="titleField">Mapa local (marca la situación del local)</label>
                    <div class="m4" id="mapid">
                    </div>
                    <div class="mb-2 mt-3 form-group text-center">
                        <button type="reset" class="btn resetbutton mt-3">BORRAR CAMPOS</button>
                        <button type="submit" id="submit" class="btn btn-primary mt-3">EDITAR CLIENTE</button>
                    </div>
            </form>
        </div>
    </div>

    <script>
        //Recojo en un json el listado de los CIF existentes para poder
        //hacer una validación que impida introducir un cliente ya introducido en la BBDD.
        //También recojo en json el listado de latitud, longitud y nombre
        //del cliente poder mostrarlo en el script que se carga a continuación y poder
        //realizar un cambio de posicionamiento si fuese necesario.
        var longitudes = {!! json_encode($client->longitude) !!};
        var latitudes = {!! json_encode($client->latitude) !!};
        var names = {!! json_encode($client->name) !!};
        let cifList = {!! json_encode($cifList) !!};
    </script>

    <script src="{{ asset('js/clientes/editar_cliente.js') }}"></script>
@endsection
