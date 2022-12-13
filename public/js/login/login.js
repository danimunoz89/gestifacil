'use strict';

let emailForm;
let femail;
let emailOk = false;

let passwordForm;
let fpassword;
let passwordOk = false;

$("form").submit(function (event) {

  femail = $("#email").get(0);
  fpassword = $("#password").get(0);

  //A través de esta función compruebo que el contenido es introducido de la forma correcta
  checkUserFields();
  if ((emailOk) && (passwordOk)) {
    return;
  }
  event.preventDefault();
});

function checkUserFields() {

  emailForm = femail.value;

  if ((!emailForm) || (!isEmail(emailForm))) {
    wrongCheck(femail, "El campo 'Email' está vacio o no tiene el formato adecuado");
    emailOk = false;
  }
  else {
    correctCheck(femail);
    emailOk = true;
  }

  passwordForm = fpassword.value;

  if ((!passwordForm)) {
    wrongCheck(fpassword, "El campo 'Contraseña' está vacio");
    passwordOk = false;
  }
  else if (((passwordForm.length > 16))) {
    wrongCheck(fpassword, "El campo tiene mas caracteres de los permitidos (16).");
    passwordOk = false;
  }
  else {
    correctCheck(fpassword);
    passwordOk = true;
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

//Función que checkea el formato del email.
function isEmail(emailForm) {
  let emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (emailRegex.test(emailForm)) {
    return true;
  }
}


