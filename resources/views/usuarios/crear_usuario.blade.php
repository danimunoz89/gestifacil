<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="forms bg-light border border-4 rounded-3">
        <h5 class="card-header text-white bg-secondary fw-bold">CREAR USUARIO</h5>
        <div class="card-body">
            <form method="post" action="{{ route('usuario_guardar') }}" name="userForm" id="userForm" class="row g-3">
                <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
                y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
                que se envían entre cliente y servidor-->
                @csrf
                <div class="col-md-6 form-group">
                    <label for="name" class="titleField">Nombre</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nombre">
                    <!--Mensaje error formulario validación servidor -->
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="lastname" class="titleField">Apellidos</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Apellidos">
                    <!--Mensaje error formulario validación servidor -->
                    @error('lastname')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="dni" class="titleField">DNI</label>
                    <input type="text" id="dni" name="dni" class="form-control" placeholder="Ej: 12345678Z">
                    <!--Mensaje error formulario validación servidor -->
                    @error('dni')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
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
                <div class="col-md-6 form-group">
                    <label for="contrasena" class="titleField">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
                    <!--Mensaje error formulario validación servidor -->
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="passrepeat" class="titleField">Repetir contraseña</label>
                    <input type="password" id="passrepeat" name="passrepeat" class="form-control"
                        placeholder="Repetir contraseña">
                    <!--Mensaje error formulario validación servidor -->
                    @error('passrepeat')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="phone" class="titleField">Teléfono</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Ej: 926926926">
                    <!--Mensaje error formulario validación servidor -->
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="role" class="titleField">Selecciona un rol</label>
                    <br>
                    <select class="form-select form-select-md mb-3" name="role" id="role">
                        <option>Selecciona un Rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <!--Mensaje error formulario validación servidor -->
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verificationSelect" class="text-danger"></div>
                </div>
                <div class="mb-2 form-group text-center">
                    <button type="reset" class="btn resetbutton mt-3">BORRAR CAMPOS</button>
                    <button type="submit" id="submit" class="btn btn-primary mt-3">CREAR USUARIO</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        //Recojo en un json el listado de los DNI y Email existentes para poder
        //hacer una validación que impida introducir un usuario ya introducido en la BBDD.
        //Estos dniList y emailList serán usados en el script que se carga a continuación.
        let dniList = {!! json_encode($dniList) !!};
        let emailList = {!! json_encode($emailList) !!};
    </script>
    <script src="{{ asset('js/usuarios/crear_usuario.js') }}"></script>
@endsection
