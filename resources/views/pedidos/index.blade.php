<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="table-responsive py-4 maincontent">

        <div class="container-fluid">
            <form method="get" action="{{ route('pedidos_index') }}" class="row g-3">
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="text" id="id" name="id" class="form-control text-center"
                        placeholder="Introduce ID Factura">
                </div>
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="text" id="name" name="name" class="form-control text-center"
                        placeholder="Introduce Cliente">
                </div>
                <div class="col-md-6 form-group m-auto mb-2">
                    <input type="date" id="date" name="date" class="form-control text-muted text-center">
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
                    <th>Nº Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Coste Total</th>
                    <th>Ficha</th>
                    <th>Editar Nota</th>
                    <th>PDF</th>
                    <!--Con role consigo deshabilitar el acceso a los usuarios que no tengan los roles señalados-->
                    @role('Administrador')
                    <th>BORRAR</th>
                    @endrole
                </tr>
            </thead>

            <tbody>
                @forelse ($orders as $salesorder)
                    <tr class="tablecells text-center align-middle fw-light">
                        <td>{{ $salesorder->id }}</td>
                        <td>{{ $salesorder->client }}</td>
                        <td>{{ $salesorder->order_date }}</td>
                        <td>{{ round(($salesorder->total_price * 1.21) ,'2')}} € (IVA incl.)</td>
                        <td>
                            <a href="#" data-bs-toggle="modal"
                                data-bs-target="#modal-sheet-{{ $salesorder->id }}"><img class="picto"
                                    src="/img/gestifacil/ficha.png" /></a>
                        </td>
                        <td>
                            <a href="{{ route('nota_editar', $salesorder->id) }}"><img class="picto"
                                    src="/img/gestifacil/nota.png" /></a>
                        </td>
                        <td>
                            <a href="{{ route('pdf_generar', $salesorder->id) }}"><img class="picto"
                                    src="/img/gestifacil/pdf.png" /></a>
                        </td>
                        @role('Administrador')
                            <td>
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-{{ $salesorder->id }}"><img class="picto"
                                        src="/img/gestifacil/eliminar.png" /></a>
                            </td>
                        @endrole
                    </tr>
                    @include('pedidos/ficha')
                    @include('pedidos/eliminar')
                @empty
                    <tr>
                        <th class="tablehead text-center" colspan="8">No hay registros</th>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <hr class="hr hr-blurry" />

        <!--Permite el paginador de datos-->
        <div class="d-flex justify-content-center">
            {{ $orders->onEachSide(3)->links() }}
        </div>
    </div>
@endsection
