<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="card bg-light border-4 rounded-3">
        <img src="{{ asset('img/gestifacil/logo2.png') }}" class="logoLogin card-header text-white bg-light mx-auto"
            title="logoLogin" alt="logoLoginGestifacil">
        <div class="card-body">
            @error('error')
                <div class="mb-4 alert alert-danger text-center">{{ $message }}</div>
            @enderror
            <form method="post" action="{{ route('login-user') }}">
                <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
                y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
                que se envían entre cliente y servidor-->                
                @csrf
                <div class="col-md-12 mx-auto mb-3 form-group">
                    <label for="email" class="titleField">Email</label>
                    <input type="text" id="email" name="email" class="form-control"
                        placeholder="Ej: ejemplo@ejemplo.com">
                    <!--Mensaje error formulario validación servidor -->
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-12 mx-auto mb-3 form-group">
                    <label for="contrasena" class="titleField">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
                    <!--Mensaje error formulario validación servidor -->
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="mb-2 form-group text-center">
                    <button type="submit" class="btn ">INICIAR SESIÓN</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/login/login.js') }}"></script>
@endsection
