<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="aboutus m-2 bg-light border-4 rounded-3">
        <div class="row g-5">
            <div class="col-md-3">
                <img class="rounded-start img-fluid logoabout" src="{{ asset('img/gestifacil/about.png') }}" />
            </div>
            <div class="col-md-8">
                <div class="card-body abouttext">
                    <h5 class="card-header text-white bg-secondary fw-bold mb-3">SOBRE NOSOTROS</h5>
                    <p class="card-text text-start">
                        GESTIFACIL es un CRM que intenta servir como solución a equipos comerciales
                        de PYMES a la hora de llevar a cabo la toma de pedidos de sus clientes.
                    </p>
                    <p class="card-text text-start">
                        GESTIFACIL está desarrollado por Daniel Muñoz para el TFG del
                        ciclo superior de Desarrollo de Aplicaciones Web (DAW)
                        impartido en el IES Maestre de Calatrava de Ciudad Real.
                    </p>
                </div>
            </div>
        @endsection
