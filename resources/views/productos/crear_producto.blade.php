<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="forms bg-light border border-4 rounded-3">
        <h5 class="card-header text-white bg-secondary fw-bold">CREAR PRODUCTO</h5>
        <div class="card-body">
            <form method="post" action="{{ route('producto_guardar') }}" class="row g-3" enctype="multipart/form-data">
                <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
                y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
                que se envían entre cliente y servidor-->
                @csrf
                <div class="col-md-6 form-group">
                    <label for="idcategory" class="titleField">Selecciona una categoría</label>
                    <br>
                    <select class="form-select form-select-md mb-3" id="idcategory" name="idcategory">
                        <option>Selecciona una categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <!--Mensaje error formulario validación servidor -->
                    @error('idcategory')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verificationSelect" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="name" class="titleField">Nombre</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nombre">
                    <!--Mensaje error formulario validación servidor -->
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="description" class="titleField">Descripción</label>
                    <textarea name="description" id="description" rows="4" cols="20" class="form-control" placeholder="Descripción"></textarea>
                    <!--Mensaje error formulario validación servidor -->
                    @error('description')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="producer" class="titleField">Fabricante</label>
                    <input type="text" id="producer" name="producer" class="form-control" placeholder="Fabricante">
                    <!--Mensaje error formulario validación servidor -->
                    @error('producer')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="format" class="titleField">Formato</label>
                    <input type="text" id="format" name="format" class="form-control" placeholder="Formato">
                    <!--Mensaje error formulario validación servidor -->
                    @error('format')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="unitprice" class="titleField">Precio unidad (sin IVA)</label>
                    <input type="text" id="unitprice" name="unitprice" class="form-control" placeholder="Precio unidad">
                    <!--Mensaje error formulario validación servidor -->
                    @error('unitprice')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="stock" class="titleField">¿Hay stock en el almacén?</label>
                    <input class="form-check-input" type="checkbox" name="stock" id="stock" value="1">
                </div>
                <div class="col-md-6 form-group">
                    <label for="image" class="titleField">Subir imagen</label>
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
                    <button type="submit" id="submit" class="btn btn-primary mt-3">CREAR PRODUCTO</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/productos/crear_producto.js') }}"></script>
@endsection
