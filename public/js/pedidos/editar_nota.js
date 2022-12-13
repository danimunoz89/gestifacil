'use strict';

let noteForm;
let fnote;
let noteOk = false;

$("form").submit(function (event) {
    fnote = $("#note").get(0);

    //A través de esta función compruebo que el contenido es introducido de la forma correcta
    checkOrderFields();
    if ((noteOk)) {
        return;
    }
    event.preventDefault();
});

function checkOrderFields() {
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