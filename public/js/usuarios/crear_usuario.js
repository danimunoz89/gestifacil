'use strict';

let nameForm;
let fname;
let nameOk = false;

let lastnameForm;
let flastname;
let lastnameOk = false;

let dniForm;
let fdni;
let dniOk = false;

let emailForm;
let femail;
let emailOk = false;

let passwordForm;
let fpassword;
let passwordOk = false;

let passrepeatForm;
let fpassrepeat;

let phoneForm;
let fphone;
let phoneOk = false;

let roleForm;
let frole;
let roleOk = false;

$("form").submit(function (event) {
  fname = $("#name").get(0);
  flastname = $("#lastname").get(0);
  fdni = $("#dni").get(0);
  femail = $("#email").get(0);
  fpassword = $("#password").get(0);
  fpassrepeat = $("#passrepeat").get(0);
  fphone = $("#phone").get(0);
  frole = $("#role").get(0);

  //A través de esta función compruebo que el contenido es introducido de la forma correcta
  checkUserFields();
  if ((nameOk) && (lastnameOk) && (dniOk) && (emailOk) && (passwordOk) && (phoneOk) && (roleOk)) {
    return;
  }
  event.preventDefault();
});

function checkUserFields() {
  nameForm = fname.value;

  if (!nameForm) {
    wrongCheck(fname, "El campo 'Nombre' no puede estar vacio");
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

  lastnameForm = flastname.value;

  if (!lastnameForm) {
    wrongCheck(flastname, "El campo 'Apellido' no puede estar vacio");
    lastnameOk = false;
  }
  else if ((lastnameForm.length > 100)) {
    wrongCheck(flastname, "El campo tiene mas caracteres de los permitidos (100).");
    lastnameOk = false;
  }
  else {
    correctCheck(flastname);
    lastnameOk = true;
  }

  dniForm = fdni.value;

  if ((!dniForm) || (!isDni(dniForm))) {
    wrongCheck(fdni, "El campo 'DNI' está vacio o no tiene el formato adecuado");
    dniOk = false;
  }
  else {
    if (dniList.includes(dniForm)) {
      wrongCheck(fdni, "El campo 'DNI' está ya incluido en la BBDD");
      dniOk = false;
    }
    else {
      correctCheck(fdni);
      dniOk = true;
    }
  }

  emailForm = femail.value;

  if ((!emailForm) || (!isEmail(emailForm))) {
    wrongCheck(femail, "El campo 'Email' está vacio o no tiene el formato adecuado");
    emailOk = false;
  }
  else {
    if (emailList.includes(emailForm)) {
      wrongCheck(femail, "El campo 'Email' está ya incluido en la BBDD");
      emailOk = false;
    }
    else {
      correctCheck(femail);
      emailOk = true;
    }
  }

  passwordForm = fpassword.value;
  passrepeatForm = fpassrepeat.value;

  if ((!passwordForm) || (passwordForm != passrepeatForm)) {
    wrongCheck(fpassword, "El campo 'Contraseña' está vacio o no coinciden las contraseñas");
    passwordOk = false;
  }
  else if (((passwordForm.length > 16) || (passwordForm != passrepeatForm))) {
    wrongCheck(fpassword, "El campo tiene mas caracteres de los permitidos (16).");
    passwordOk = false;
  }
  else {
    correctCheck(fpassword);
    passwordOk = true;
  }

  phoneForm = fphone.value;

  if ((!phoneForm) || (!isPhone(phoneForm))) {
    wrongCheck(fphone, "El campo 'Teléfono' está vacio o no tiene el formato adecuado");
    phoneOk = false;
  }
  else {
    correctCheck(fphone);
    phoneOk = true;
  }

  roleForm = frole.value;

  if (!(roleForm == "1") && !(roleForm == "2")) {
    wrongSelectCheck(frole, "Selecciona un rol para el usuario");
    roleOk = false;
  } else {
    correctSelectCheck(frole);
    roleOk = true;
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

//Función que checkea el formato del email.
function isEmail(emailForm) {
  let emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (emailRegex.test(emailForm)) {
    return true;
  }
}

//Función que checkea el formato del DNI.
function isDni(dniForm) {
  let dniRegex = /^[0-9\-]{7,8}[A-z]?$/;
  if (dniRegex.test(dniForm)) {
    return true;
  }
}

//Función que checkea el formato del teléfono.
function isPhone(phoneForm) {
  let phoneRegex = /^(6|8|9)[0-9]{8}$/;
  if (phoneRegex.test(phoneForm)) {
    return true;
  }
}

