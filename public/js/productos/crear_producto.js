'use strict';

let categoryForm;
let fcategory;
let categoryOk = false;

let nameForm;
let fname;
let nameOk = false;

let descriptionForm;
let fdescription;
let descriptionOK = false;

let producerForm;
let fproducer;
let producerOk = false;

let formatForm;
let fformat;
let formatOk = false;

let unit_priceForm;
let funit_price;
let unit_priceOk = false;

let imageForm;
let fimage;
let imageOk = false;

$("form").submit(function (event) {
    fcategory = $("#idcategory").get(0);
    fname = $("#name").get(0);
    fdescription = $("#description").get(0);
    fproducer = $("#producer").get(0);
    fformat = $("#format").get(0);
    funit_price = $("#unitprice").get(0);
    fimage = $("#image").get(0);

    //A través de esta función compruebo que el contenido es introducido de la forma correcta
    checkProductFields();
    if ((categoryOk) && (nameOk) && (producerOk) && (descriptionOK) && (formatOk) && (unit_priceOk) && (imageOk)) {
        return;
    }
    event.preventDefault();
});

function checkProductFields() {
    categoryForm = fcategory.value;

    if (categoryForm == "Selecciona una categoría") {
        wrongSelectCheck(fcategory, "Selecciona una categoría para el producto.");
        categoryOk = false;
    } else {
        correctSelectCheck(fcategory);
        categoryOk = true;
    }

    nameForm = fname.value;

    if (!nameForm) {
        wrongCheck(fname, "El campo 'Nombre' no puede estar vacio.");
        nameOk = false;
    }
    else if ((nameForm.length > 100)) {
        wrongCheck(fname, "El campo tiene mas caracteres de los permitidos (100).");
        nameOk = false;
    }
    else {
        correctCheck(fname);
        nameOk = true;
    }

    descriptionForm = fdescription.value;

    if ((descriptionForm.length > 255)) {
        wrongCheck(fdescription, "El campo tiene mas caracteres de los permitidos (255).");
        descriptionOK = false;
    }
    else {
        correctCheck(fdescription);
        descriptionOK = true;
    }

    producerForm = fproducer.value;

    if (!producerForm) {
        wrongCheck(fproducer, "El campo 'Fabricante' no puede estar vacio.");
        producerOk = false;
    }
    else if ((producerForm.length > 100)) {
        wrongCheck(fproducer, "El campo tiene mas caracteres de los permitidos (100).");
        producerOk = false;
    }
    else {
        correctCheck(fproducer);
        producerOk = true;
    }

    formatForm = fformat.value;

    if (!formatForm) {
        wrongCheck(fformat, "El campo 'Formato' no puede estar vacio.");
        formatOk = false;
    }
    else if ((formatForm.length > 100)) {
        wrongCheck(fformat, "El campo tiene mas caracteres de los permitidos (100).");
        formatOk = false;
    }
    else {
        correctCheck(fformat);
        formatOk = true;
    }

    unit_priceForm = funit_price.value;

    if (!unit_priceForm) {
        wrongCheck(funit_price, "El campo 'Precio Unidad' no puede estar vacio.");
        unit_priceOk = false;
    }
    else if (isNaN(unit_priceForm)) {
        wrongCheck(funit_price, "El campo 'Precio Unidad' tiene que ser numérico.");
        unit_priceOk = false;
    }
    else if (unit_priceForm < 0) {
        wrongCheck(funit_price, "El campo 'Precio Unidad' no puede ser negativo.");
        unit_priceOk = false;
    }
    else {
        correctCheck(funit_price);
        unit_priceOk = true;
    }

    imageForm = fimage.value;

    if (!(imageForm)) {
        wrongCheck(fimage, "El campo 'Imagen' está vacio.");
        imageOk = false;
    }
    else if (!isImage(imageForm)) {
        wrongCheck(fimage, "El campo 'Imagen' no tiene el formato correcto (jpeg,png,jpg).");
        imageOk = false;
    }
    else if (!sizeCorrect()) {
        wrongCheck(fimage, "El archivo es mayor de 2000kb (2MB)");
        imageOk = false;
    }
    else {
        correctCheck(fimage);
        imageOk = true;
    }
}

//Las siguientes funciones permitirán mostrar los mensajes de aviso de "error"
//en los formularios en caso que no se pasen las validaciones de forma satisfactoria.

function correctCheck(input) {
    let containerInput = input.parentElement;
    let veri = containerInput.querySelector('#verification');
    veri.innerText = "";
}

function wrongCheck(input, mensaje) {
    let containerInput = input.parentElement;
    let veri = containerInput.querySelector('#verification');
    veri.innerText = mensaje;
}

function wrongSelectCheck(select, mensaje) {
    let containerSelect = select.parentElement;
    let veri = containerSelect.querySelector('#verificationSelect');
    veri.innerText = mensaje;
}

function correctSelectCheck(select) {
    let containerSelect = select.parentElement;
    let veri = containerSelect.querySelector('#verificationSelect');
    veri.innerText = "";
}

//Función que checkea el formato del imagen.
function isImage(images) {
    let imagesRegex = /([A-z\-_0-9\/\.]*\.(png|jpg|jpeg))/;
    if (imagesRegex.test(images)) {
        return true;
    }
}

//Función que checkea el tamaño de la imagen.
function sizeCorrect() {
    var file_size = $("#image").get(0).files[0].size;
    //2MB
    if (file_size < 2097152) {
        return true;
    }
}
