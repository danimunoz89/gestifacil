<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="table-responsive py-4 maincontent-categories">

        <div class="container-fluid">
            <form method="GET" action="{{ route('categoria_index') }}" class="row g-3">
                <div class="col-md-10 m-auto mb-2 form-group ">
                    <select class="form-select form-select-md text-center text-muted" id="category" name="category">
                        <option value="0">Selecciona una categoría</option>
                        @foreach ($categoriesSelect as $categorySelect)
                            <option value="{{ $categorySelect->id }}">{{ $categorySelect->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 form-group m-auto mb-2 text-center">
                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                </div>
            </form>
        </div>

        <hr class="hr hr-blurry" />

        <table class="table table-light table-hover border border-5 rounded">

            <thead class="tablehead text-center align-middle text-uppercase">
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th colspan="2">Editar/Borrar</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $category)
                    <tr class="tablecells text-center align-middle fw-light">
                        <td>                           
                            <img class="prodcats" src="/img/categories/{{ stream_get_contents($category->image) }}">
                        </td>
                        <td>{{ $category->name }}</td>

                        <!--Con role consigo deshabilitar el acceso a los usuarios que no tengan los roles señalados-->
                        @role('Administrador')
                            <td>
                                <a href="{{ route('categoria_editar', $category->id) }}"><img class="picto"
                                        src="/img/gestifacil/editar.png" /></a>
                            </td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $category->id }}"><img
                                        class="picto" src="/img/gestifacil/eliminar.png" /></a>
                            </td>
                        @endrole
                    </tr>
                    @include('categorias/eliminar')
                @empty
                    <tr>
                        <th class="tablehead text-center" colspan="4">No hay registros</th>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <hr class="hr hr-blurry" />

        <!--Permite el paginador de datos-->
        <div class="d-flex justify-content-center">
            {{ $categories->onEachSide(3)->links() }}
        </div>
    @endsection
