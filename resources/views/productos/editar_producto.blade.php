<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="forms bg-light border border-4 rounded-3">
        <h5 class="card-header text-white bg-secondary fw-bold">EDITAR PRODUCTO</h5>
        <div class="card-body">
            <form method="post" action="{{ route('producto_actualizar', $product->id) }}" class="row g-3"
                enctype="multipart/form-data">
                <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
                y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
                que se envían entre cliente y servidor-->                
                @csrf
                <div class="col-md-6 form-group">
                    <label for="idcategory" class="titleField">Selecciona una categoría</label>
                    <br>
                    <select name="idcategory" id="idcategory">
                        <option>Selecciona una categoria</option>
                        @foreach ($categories as $category)
                            @if ($category->id == $product->id_category)
                                <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
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
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nombre"
                        value="{{ $product->name }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="description" class="titleField">Descripción</label>
                    <textarea name="description" id="description" rows="4" cols="20" class="form-control" placeholder="Descripción">{{ $product->description }}</textarea>
                    <!--Mensaje error formulario validación servidor -->
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="producer" class="titleField">Fabricante</label>
                    <input type="text" id="producer" name="producer" class="form-control" placeholder="Fabricante"
                        value="{{ $product->producer }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('producer')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="format" class="titleField">Formato</label>
                    <input type="text" id="format" name="format" class="form-control" placeholder="Formato"
                        value="{{ $product->format }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('format')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="unitprice" class="titleField">Precio unidad (sin IVA)</label>
                    <input type="text" id="unitprice" name="unitprice" class="form-control" placeholder="Precio unidad"
                        value="{{ round(($product->unit_price) ,'2') }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('unitprice')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="stock" class="titleField">¿Hay stock en el almacén?</label>
                    @if ($product->stock == 0)
                        <input class="form-check-input" type="checkbox" name="stock" id="stock" value="1">
                    @else
                        <input class="form-check-input" type="checkbox" name="stock" id="stock" value="1"
                            checked>
                    @endif
                </div>
                <div class="col-md-6 form-group">
                    <label for="image" class="titleField">Imagen actual</label>
                    <img class="prodcats" src="/img/products/{{ stream_get_contents($product->image) }}">
                    <!--Campo oculto que utilizo para recoger la imagen actual existente para
                    posteriormente editar en el controller la imagen, borrando la actual (si fuese necesario) y
                    reemplazándola por una nueva subida por el usuario-->
                    <input type="hidden" id="current_image" name="current_image" value="{{ stream_get_contents($product->image) }}" />
                </div>
                <div class="row-md-6 form-group">
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
                    <button type="submit" id="submit" class="btn btn-primary mt-3">EDITAR PRODUCTO</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/productos/editar_producto.js') }}"></script>
@endsection
