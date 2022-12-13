'use strict';

let clientForm;
let fclient;
let clientOk = false;

let productForm;
let fproduct;
let productOk = false;

let stockForm;
let fstock;
let stockOk = false;

let noteForm;
let fnote;
let noteOk = false;

$("form").submit(function (event) {
    fclient = $("#client").get(0);
    fproduct = $(".product").get(0);
    fstock = $(".stock").get(0);
    fnote = $("#note").get(0);

    //A través de esta función compruebo que el contenido es introducido de la forma correcta
    checkOrderFields();
    if ((clientOk) && (noteOk) && (productOk) && (stockOk)) {
        return;
    }
    event.preventDefault();
});

function checkOrderFields() {
    clientForm = fclient.value;

    if (clientForm == "0") {
        wrongSelectCheck2(fclient, "Revisa que el cliente esté seleccionado.");
        clientOk = false;
    } else {
        correctSelectCheck2(fclient);
        clientOk = true;
    }

    productForm = fproduct.value;

    if (productForm == "Selecciona un Producto") {
        wrongSelectCheck(fproduct, "Revisa que algún producto no esté seleccionado.");
        productOk = false;
    } else {
        correctSelectCheck(fproduct);
        productOk = true;
    }

    stockForm = fstock.value;

    if (!stockForm || isNaN(stockForm)) {
        wrongCheck(fstock, "Revisa que alguna cantidad no esté sin rellenar o no sea un número");
        stockOk = false;
    }
    else if (stockForm <= 0) {
        wrongCheck(fstock, "El campo 'Cantidad' tiene que ser mayor que 0");
        stockOk = false;
    }
    else {
        correctCheck(fstock);
        stockOk = true;
    }

    noteForm = fnote.value;

    if ((noteForm.length > 255)) {
        wrongNoteCheck(fnote, "El campo Nota tiene mas caracteres de los permitidos (255).");
        noteOk = false;
    }
    else {
        correctNoteCheck(fnote);
        noteOk = true;
    }
}

//Las siguientes funciones permitirán mostrar los mensajes de aviso de "error"
//en los formularios en caso que no se pasen las validaciones de forma satisfactoria.

function correctCheck(input) {
    let containerInput = document.getElementById("errores");
    let veri = containerInput.querySelector('#verification');
    veri.innerText = "";
}

function wrongCheck(input, mensaje) {
    let containerInput = document.getElementById("errores");
    let veri = containerInput.querySelector('#verification');
    veri.innerText = mensaje;
}

function wrongSelectCheck(select, mensaje) {
    let containerSelect = document.getElementById("errores");
    let veri = containerSelect.querySelector('#verificationSelect');
    veri.innerText = mensaje;
}

function correctSelectCheck(select) {
    let containerSelect = document.getElementById("errores");
    let veri = containerSelect.querySelector('#verificationSelect');
    veri.innerText = "";
}

function wrongSelectCheck2(select, mensaje) {
    let containerSelect = document.getElementById("errores");
    let veri = containerSelect.querySelector('#verificationSelect2');
    veri.innerText = mensaje;
}

function correctSelectCheck2(select) {
    let containerSelect = document.getElementById("errores");
    let veri = containerSelect.querySelector('#verificationSelect2');
    veri.innerText = "";
}

function correctNoteCheck(input) {
    let containerInput = document.getElementById("errores");
    let veri = containerInput.querySelector('#verificationNote');
    veri.innerText = "";
}

function wrongNoteCheck(input, mensaje) {
    let containerInput = document.getElementById("errores");
    let veri = containerInput.querySelector('#verificationNote');
    veri.innerText = mensaje;
}