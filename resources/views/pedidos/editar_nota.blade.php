<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="forms bg-light border border-4 rounded-3">
        <h5 class="card-header text-white bg-secondary fw-bold">EDITAR NOTA PEDIDO</h5>
        <div class="card-body">
            <form method="post" action="{{ route('nota_actualizar', $salesorder[0]->id) }}" class="row g-3">
                <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
                y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
                que se envían entre cliente y servidor-->
                @csrf
                <div class="col-md-6 form-group">
                    <label for="name" class="titleField">Cliente</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ $salesorder[0]->client }}" readonly>
                </div>
                <div class="col-md-6 form-group">
                    <label for="visit_date" class="titleField">Fecha pedido</label>
                    <input type="date" id="visit_date" name="visit_date" class="form-control text-muted"
                        value="{{ $salesorder[0]->order_date }}" readonly>
                </div>
                <div class="col mt-4">
                    <div class="col-md-12 form-group">
                        <label for="note" class="titleField">Nota</label>
                        <textarea name="note" id="note" rows="4" wrap="soft" class="form-control" placeholder="Nota">{{ $salesorder[0]->note }}</textarea>
                    </div>
                    <div class="col-md-12 mt-3 text-center form-group" id="errores">
                        <!--Mensaje error formulario validación servidor -->
                        @error('note')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <!--Mensaje error formulario validación cliente -->
                        <div id="verificationNote" class="text-danger"></div>
                    </div>
                    <div class="col-md-12 text-center form-group mt-4">
                        <button type="submit" class="btn btn-primary">EDITAR NOTA PEDIDO</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/pedidos/editar_nota.js') }}"></script>
@endsection
