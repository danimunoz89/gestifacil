'use strict';

//Generación del mapa através de openstreetmap.
//Cada vez que un usuario haga click en el mapa esté cambiará la posición
//del "puntero". Cada vez que un usuario haga click, se recogerá la posición (latitud/longitud)
//del lugar marcado ("borrándose la anterior"). Esa información será insertada en los inputs correspondientes
//del formulario de creación de clientes.

let latitudForm;
let longitudForm;
let mapContainer = $('#mapid');

mapContainer.css({
  height: '350px',
  border: '2px solid #000000'
});

let map = L.map('mapid').setView([38.990831799999995, -3.9206173000000004], 15);

L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BYSA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>', maxZoom: 18
}).addTo(map);

map.on('click', function (event) {
  map.eachLayer((layer) => {
    if (layer['_latlng'] != undefined)
      layer.remove();
  });

  L.marker([event.latlng.lat, event.latlng.lng]).addTo(map);
  longitudForm = event.latlng.lng;
  latitudForm = event.latlng.lat;
  $('#longitude').val(longitudForm);
  $('#latitude').val(latitudForm);
});


let nameForm;
let fname;
let nameOk = false;

let cifForm;
let fcif;
let cifOk = false;

let emailForm;
let femail;
let emailOk = false;

let phoneForm;
let fphone;
let phoneOk = false;

let zipForm;
let fzip;
let zipOk = false;

let addressForm;
let faddress;
let addressOk = false;

let townForm;
let ftown;
let townOK = false;

let provinceForm;
let fprovince;
let provinceOk = false;

let ownerForm;
let fowner;
let ownerOk = false;

let userForm;
let fuser;
let userOk = false;

$("form").submit(function (event) {
  fname = $("#name").get(0);
  fcif = $("#cif").get(0);
  femail = $("#email").get(0);
  fphone = $("#phone").get(0);
  fzip = $("#zip").get(0);
  faddress = $("#address").get(0);
  ftown = $("#town").get(0);
  fprovince = $("#province").get(0);
  fowner = $("#owner").get(0);
  fuser = $("#iduser").get(0);

  //A través de esta función compruebo que el contenido es introducido de la forma correcta
  checkClientFields();
  if ((nameOk) && (cifOk) && (emailOk) && (phoneOk) && (zipOk) && (addressOk) && (townOK) && (provinceOk) && (ownerOk) && (userOk)) {
    return;
  }
  event.preventDefault();
});

function checkClientFields() {
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

  cifForm = fcif.value;

  if ((!cifForm) || (!isCIF(cifForm))) {
    wrongCheck(fcif, "El campo 'CIF' está vacio o no tiene el formato adecuado.");
    cifOk = false;
  }
  else {
    if (cifList.includes(cifForm)) {
      wrongCheck(fcif, "El campo 'CIF' está ya incluido en la BBDD.");
      cifOk = false;
    }
    else {
      correctCheck(fcif);
      cifOk = true;
    }
  }

  emailForm = femail.value;

  if ((!emailForm) || (!isEmail(emailForm))) {
    wrongCheck(femail, "El campo 'Email' está vacio o no tiene el formato adecuado.");
    emailOk = false;
  }
  else {
    correctCheck(femail);
    emailOk = true;
  }

  phoneForm = fphone.value;

  if ((!phoneForm) || (!isPhone(phoneForm))) {
    wrongCheck(fphone, "El campo 'Teléfono' está vacio o no tiene el formato adecuado.");
    phoneOk = false;
  }
  else {
    correctCheck(fphone);
    phoneOk = true;
  }

  zipForm = fzip.value;

  if (!zipForm) {
    wrongCheck(fzip, "El campo 'CP' no puede estar vacio.");
    zipOk = false;
  }
  else if ((zipForm.length > 5)) {
    wrongCheck(fzip, "El campo tiene mas caracteres de los permitidos (5).");
    zipOk = false;
  }
  else {
    correctCheck(fzip);
    zipOk = true;
  }

  addressForm = faddress.value;

  if (!addressForm) {
    wrongCheck(faddress, "El campo 'Dirección' no puede estar vacio.");
    addressOk = false;
  }
  else if ((addressForm.length > 255)) {
    wrongCheck(faddress, "El campo tiene mas caracteres de los permitidos (255).");
    addressOk = false;
  }
  else {
    correctCheck(faddress);
    addressOk = true;
  }

  townForm = ftown.value;

  if (!townForm) {
    wrongCheck(ftown, "El campo 'Localidad' no puede estar vacio.");
    townOK = false;
  }
  else if ((townForm.length > 255)) {
    wrongCheck(ftown, "El campo tiene mas caracteres de los permitidos (255).");
    townOK = false;
  }
  else {
    correctCheck(ftown);
    townOK = true;
  }

  provinceForm = fprovince.value;

  if (!provinceForm) {
    wrongCheck(fprovince, "El campo 'Provincia' no puede estar vacio.");
    provinceOk = false;
  }
  else if ((provinceForm.length > 255)) {
    wrongCheck(fprovince, "El campo tiene mas caracteres de los permitidos (255).");
    provinceOk = false;
  }
  else {
    correctCheck(fprovince);
    provinceOk = true;
  }

  ownerForm = fowner.value;

  if (!ownerForm) {
    wrongCheck(fowner, "El campo 'Dueño/Responsable' no puede estar vacio.");
    ownerOk = false;
  }
  else if ((ownerForm.length > 100)) {
    wrongCheck(fowner, "El campo tiene mas caracteres de los permitidos (255).");
    ownerOk = false;
  }
  else {
    correctCheck(fowner);
    ownerOk = true;
  }

  userForm = fuser.value;

  if (userForm == "Selecciona un comercial") {
    wrongSelectCheck(fuser, "Selecciona un comercial para el cliente.");
    userOk = false;
  } else {
    correctSelectCheck(fuser);
    userOk = true;
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

//Función que checkea el formato del CIF.
function isCIF(dniForm) {
  let dniRegex = /^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/;
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

