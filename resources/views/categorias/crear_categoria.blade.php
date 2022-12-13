<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="forms bg-light border border-4 rounded-3">
        <h5 class="card-header text-white bg-secondary fw-bold">CREAR CATEGORÍA</h5>
        <div class="card-body">
            <form method="post" action="{{ route('categoria_guardar') }}" class="row g-3" enctype="multipart/form-data">
                <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
                     y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
                    que se envían entre cliente y servidor-->
                @csrf
                <div class="col-md-6 form-group">
                    <label for="name" class="titleField">Nombre</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Categoría">
                    <!--Mensaje error formulario validación servidor -->
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="row-md-6 form-group">
                    <label for="image" class="titleField">Subir Imagen</label>
                    <input type="file" id="image" name="image" class="form-control">
                    <!--Mensaje error formulario validación servidor -->
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="mb-2 form-group text-center">
                    <button type="reset" class="btn resetbutton mt-3">BORRAR CAMPOS</button>
                    <button type="submit" id="submit" class="btn btn-primary mt-3">CREAR CATEGORÍA</button>
            </form>
        </div>
    </div>
    <script>
        //Recojo en un json el listado de las categorías existentes para poder
        //hacer una validación que impida introducir una categoría ya introducida en la BBDD.
        //Este categoriesList será usado en el script que se carga a continuación.
        let categoriesList = {!! json_encode($categoriesList) !!};
    </script>
    <script src="{{ asset('js/categorias/crear_categoria.js') }}"></script>
@endsection
