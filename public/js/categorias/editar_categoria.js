'use strict';

let nameForm;
let fname;
let nameOk = false;

let imageForm;
let fimage;
let imageOk = false;

$("form").submit(function (event) {
    fname = $("#name").get(0);
    fimage = $("#image").get(0);

    //A través de esta función compruebo que el contenido es introducido de la forma correcta
    checkCategoryFields();
    if ((nameOk) && (imageOk)) {
        return;
    }
    event.preventDefault();
});

function checkCategoryFields() {

    nameForm = fname.value;

    if ((!nameForm)) {
        wrongCheck(fname, "El campo 'Nombre' está vacio.");
        nameOk = false;
    }
    else if ((nameForm.length > 100)) {
        wrongCheck(fname, "El campo tiene mas caracteres de los permitidos (100).");
        nameOk = false;
    }
    else {
        if (categoriesList.includes(nameForm)) {
            wrongCheck(fname, "El campo 'Nombre' está ya incluido en la BBDD.");
            nameOk = false;
        }
        else {
            correctCheck(fname);
            nameOk = true;
        }
    }

    imageForm = fimage.value;

    if (!(imageForm)) {
        correctCheck(fimage);
        imageOk = true;
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