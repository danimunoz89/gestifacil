<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')

    <div class="table-responsive py-4 maincontent">
        <div class="container-fluid">
            <form method="get" action="{{ route('producto_index') }}" class="row g-3">
                <div class="col-md-3 form-group m-auto mb-2">
                    <select class="form-select form-select-md text-center text-muted" id="category" name="category">
                        <option value="0">Selecciona una categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group m-auto mb-2">
                    <input type="text" id="name" name="name" class="form-control text-center"
                        placeholder="Introduce Producto">
                </div>
                <div class="col-md-3 form-group m-auto mb-2">
                    <input type="text" id="producer" name="producer" class="form-control text-center"
                        placeholder="Introduce Fabricante">
                </div>
                <div class="col-md-3 form-group m-auto mb-2">
                    <input type="text" id="format" name="format" class="form-control text-center"
                        placeholder="Introduce Formato">
                </div>
                <div class="form-group text-center m-auto">
                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                </div>
            </form>
        </div>

        <hr class="hr hr-blurry" />

        <table class="table table-light table-hover border border-5 rounded">

            <thead class="tablehead text-center text-uppercase align-middle">
                <tr>
                    <th>Imagen</th>
                    <th>Categoría</th>
                    <th>Producto</th>
                    <th>Fabricante</th>
                    <th>Formato</th>
                    <th>Precio Unidad</th>
                    <th>Ficha</th>
                    <!--Con role consigo deshabilitar el acceso a los usuarios que no tengan los roles señalados-->
                    @role('Administrador')
                    <th colspan="2">Editar/Borrar</th>
                    @endrole
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr class="tablecells text-center align-middle fw-light">
                        <td>
                            <img class="prodcats" src="/img/products/{{ stream_get_contents($product->image) }}">
                        </td>
                        <td>{{ $product->namecategory }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->producer }}</td>
                        <td>{{ $product->format }}</td>
                        <td>{{ round(($product->unit_price) ,'2') }} € (sin IVA)</td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-sheet-{{ $product->id }}"><img
                                    class="picto" src="/img/gestifacil/ficha.png" /></a>
                        </td>

                        @role('Administrador')
                            <td>
                                <a href="{{ route('producto_editar', $product->id) }}"><img class="picto"
                                        src="/img/gestifacil/editar.png" /></a>
                            </td>
                            <td>
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-{{ $product->id }}"><img class="picto"
                                        src="/img/gestifacil/eliminar.png" /></a>
                            </td>
                        @endrole
                    </tr>
                    @include('productos/ficha')
                    @include('productos/eliminar')
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
            {{ $products->onEachSide(3)->links() }}
        </div>
    </div>
@endsection
