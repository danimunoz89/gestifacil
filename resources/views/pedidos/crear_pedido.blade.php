<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="forms bg-light border border-4 rounded-3">
        <h5 class="card-header text-white bg-secondary fw-bold">CREAR PEDIDO</h5>
        <div class="card-body">

            <div class="row mb-4 text-center">
                <div class="col-md-6 form-group mx-auto">
                    <button class="btn addbutton btn-success mt-3" id="addRow">Añadir Fila</button>
                </div>
                <div class="col-md-6  form-group mx-auto">
                    <button class="btn deletebutton btn-danger mt-3" id="deleteRow">Eliminar Fila</button>
                </div>
            </div>

            <form method="post" action="{{ route('pedido_guardar') }}" class="row g-3 justify-content-center">
                <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
                y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
                que se envían entre cliente y servidor-->                
                @csrf
                <div class="row">
                    <div class="text-center" id="rowAdded">
                        <div class="orderFormFields text-center">
                            <div class="row ml-r justify-content-center mb-3">
                                <div class="col-md-6 text-center form-group">
                                    <label for="id_client" class="titleField mt-3">Selecciona Cliente</label>

                                    <select name="client" class="form-control text-center" id="client">
                                        <option value="0">Selecciona un cliente</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 text-center form-group">
                                    <label for="order_date" class="titleField mt-3">Fecha Realización Pedido</label>
                                    <input type="date" id="order_date" name="order_date"
                                        class="form-control text-center text-muted" value={{ date('Y-m-d') }} readonly>
                                </div>

                                <!--Mensaje error formulario validación cliente -->
                                <div class="col-md-12 mt-4 text-center form-group" id="errores">
                                    <div id="verificationSelect2" class="text-danger"></div>
                                    <div id="verificationSelect" class="text-danger"></div>
                                    <div id="verification" class="text-danger"></div>
                                    <div id="verificationNote" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col mt-4 text-center">
                    <div class="col-md-12 form-group">
                        <label for="note" class="titleField">Nota</label>
                        <textarea name="note" id="note" rows="4" wrap="soft" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12 form-group mt-4">
                        <button type="button" class="btn btn-primary" id="modal" data-bs-toggle="modal"
                            data-bs-target="#modal-confirm">CONFIRMAR PEDIDO</button>
                        @include('pedidos/confirmar')
                    </div>
                </div>
            </form>

        </div>
    </div>
    <script src="{{ asset('js/pedidos/crear_pedido.js') }}"></script>
@endsection

<script type="module">
//El presente script no lo he podido llevar a un fichero a parte como el resto de validaciones
//debido a que no me recogía los elementos dinámicos del formulario de la manera adecuada. Es por ello que he optado
//a ponerlos dentro del blade.

//La siguiente función permite añadir/borrar de forma dinámica filas en el formulario.

$(document).ready(function () {

    //Voy contando el número de divs con el class row contenido dentro de la clase orderFormFields
    //De este modo consigo que cada uno de los elementos de la fila pueda tener un identificador único
    //que me permita luego hacer la insercción de los elementos en la BBDD.

    let rowNum = $('#rowAdded .orderFormFields .row').length;

    $("#rowAdded .orderFormFields").append(

        '<div class="row justify-content-center text-center ml-r">' +
        //Esta cabecera podría ir fuera del script, pero me descuadraba todo al intentar luego
        //introducir cada fila nueva. Metiendo esta cabecera dentro del script en el momento de carga de página
        //el problema queda solucionado.
        '<div class="col-md-3 titleField form-group">' +
        'Producto' +
        '</div>' +
        '<div class="col-md-3 titleField form-group">' +
        'Precio (€)' +
        '</div>' +
        '<div class="col-md-3 titleField form-group">' +
        'Cantidad (uds.)' +
        '</div>' +
        '</div>' +

        '<div class="row text-center justify-content-center mb-2">' +
        '<div class="col-md-3 form-group">' +
        '<select name="product[]" id="idprod' + rowNum + '" class="form-control text-center product">' +
        '<option>Selecciona un Producto</option>' +
        '@foreach($products as $product)' +
        '<option value="{{$product->name}}/{{round(($product->unit_price) ,"2") }}/{{$product->id}}">{{$product->name}}</option>' +
        '@endforeach' +
        '</select>' +
        '</div>' +
        '<div class="col-md-3 form-group">' +
        '<input type="text" name="price[]" id="price' + rowNum + '" class="form-control price text-center" readonly>' +
        '</div>' +
        '<div class="col-md-3 form-group">' +
        '<input type="text" name="quantity[]" id="quantity' + rowNum + '" class="form-control text-center stock">' +
        '</div>' +
        '</div>');
});

$("#addRow").click(function () {

    let rowNum = $('#rowAdded .orderFormFields .row').length;

    $("#rowAdded .orderFormFields").append('<div class="row text-center justify-content-center mb-2">' +
        '<div class="col-md-3 form-group">' +
        '<select name="product[]" id="idprod' + rowNum + '" class="form-control product text-center">' +
        '<option>Selecciona un Producto</option>' +
        '@foreach($products as $product)' +
        '<option value="{{$product->name}}/{{round(($product->unit_price) ,"2")}}/{{$product->id}}">{{$product->name}}</option>' +
        '@endforeach' +
        '</select>' +
        '</div>' +
        '<div class="col-md-3 form-group">' +
        '<input type="text" name="price[]" id="price' + rowNum + '" class="form-control text-center price" readonly>' +
        '</div>' +
        '<div class="col-md-3 form-group">' +
        '<input type="text" name="quantity[]" id="quantity' + rowNum + '" class="form-control text-center stock">' +
        '</div>' +
        '</div>');
});

//Elimino las filas pulsando el botón "Eliminar Fila" menos las 2 últimas
// para conseguir que siempre haya una fila en la que poder insertar campos.
//La primera fila que cuenta es la que contiene los campos Selecciona Cliente y Fecha Realizacion Pedido.

$("#deleteRow").click(function () {
let rowNum = $('#rowAdded .orderFormFields .row').length;

if (rowNum > 3) {
    $("#rowAdded .orderFormFields .row").last().remove();
}
});

//La siguiente función permite que, seleccionado un producto, se muestre
//de forma dinámica su precio en un input del formulario.

let productV = ".product";
let priceV = ".price";

$(document).on("change", (productV), function (e) {
    let value = $.trim($(this).val());
    let price = value.split("/");
$(this).closest('.row').find(priceV).val(price[1]);
});

</script>
