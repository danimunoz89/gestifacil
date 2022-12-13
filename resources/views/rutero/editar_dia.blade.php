<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="forms bg-light border border-4 rounded-3">
        <h5 class="card-header text-white bg-secondary fw-bold">EDITAR FECHA VISITA</h5>
        <div class="card-body">
            <form method="post" action="{{ route('dia_actualizar', $client->id) }}" class="row g-3">
                <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
                y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
                que se envían entre cliente y servidor-->
                @csrf
                <div class="row gx-5 mb-3 mt-3">
                    <div class="col-md-4 form-group">
                        <label for="name" class="titleField">Nombre del local</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $client->name }}"
                            readonly>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="cif" class="titleField">CIF</label>
                        <input type="text" id="cif" name="cif" class="form-control" value="{{ $client->cif }}"
                            readonly>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="visit_date" class="titleField">Fecha visita</label>
                        <input type="date" id="visit_date" name="visit_date" class="form-control"
                            value="{{ $client->visit_date }}">
                    </div>
                </div>
                <div class="mb-2 form-group text-center">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">CAMBIAR FECHA VISITA</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
