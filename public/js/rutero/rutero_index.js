'use strict';

//Generación del mapa através de openstreetmap.
//Se recoge la información referente a la posición (longitud/latitud) y el nombre de los clientes en un dia concreto marcado
//para un usuario en concreto.
//Se recorren los arrays de longitud y latitud y se van pintando en el mapa.

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

for (let i = 0; i < longitudes.length; i++) {
    L.marker([latitudes[i], longitudes[i]]).addTo(map).bindPopup(`${names[i]}`).openPopup();
}