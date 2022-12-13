<!--Defino en que plantilla voy a incrustar el presente blade-->
@extends('plantilla.plantilla')
<!--Defino en que sección de la plantilla voy a incrustar el presente blade-->
@section('contenidoPrincipal')
    <div class="forms bg-light border border-4 rounded-3">
        <h5 class="card-header text-white bg-secondary fw-bold">EDITAR USUARIO</h5>
        <div class="card-body">
            <form method="post" action="{{ route('usuario_actualizar', $user->id) }}" name="userForm" id="userForm"
                class="row g-3">
                <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
                y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
                que se envían entre cliente y servidor-->                
                @csrf
                <div class="col-md-6 form-group">
                    <label for="name" class="titleField">Nombre</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nombre"
                        value="{{ $user->name }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="lastname" class="titleField">Apellidos</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Apellidos"
                        value="{{ $user->lastname }}">
                    <!--Mensaje error formulario validación servidor -->
                    @error('lastname')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="dni" class="titleField">DNI</label>
                    <input type="text" id="dni" name="dni" class="form-control" placeholder="Ej: 12345678Z"
                        value="{{ $user->dni }}" readonly>
                    <!--Mensaje error formulario validación servidor -->
                    @error('dni')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="email" class="titleField">Email</label>
                    @if ($user->email != 'admin@admin.com')
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Ej: ejemplo@ejemplo.com" value="{{ $user->email }}">
                    @else
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Ej: ejemplo@ejemplo.com" value="{{ $user->email }}" readonly>
                    @endif
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
                    <label for="passrepeat" class="titleField">Confirmar contraseña</label>
                    <!--Mensaje error formulario validación servidor -->
                    @error('passrepeat')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <input type="password" id="passrepeat" name="passrepeat" class="form-control"
                        placeholder="Repetir contraseña">
                </div>
                <div class="col-md-6 form-group">
                    <label for="phone" class="titleField">Teléfono</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ $user->phone }}"
                        placeholder="Ej: 926926926">
                    <!--Mensaje error formulario validación servidor -->
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verification" class="text-danger"></div>
                </div>
                @if ($user->dni != 000000000)
                <div class="col-md-6 form-group">
                    <label for="role" class="titleField">Elige un rol</label>
                    <br>
                    <select class="form-select form-select-md mb-3" name="role" id="role">
                        <option>Selecciona un Rol</option>
                        @foreach ($roles as $role)
                            @if ($role->model_id == $user->id && $role->role_id == 1)
                                <option selected value="1">Administrador</option>
                            @else
                                <option selected value="2">Usuario</option>
                            @endif
                            @if ($role->role_id == 1)
                                <option value="2">Usuario</option>
                            @else
                                <option value="1">Administrador</option>
                            @endif
                        @endforeach
                    </select>
                    <!--Mensaje error formulario validación servidor -->
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!--Mensaje error formulario validación cliente -->
                    <div id="verificationSelect" class="text-danger"></div>
                </div>
                @endif
                <div class="mb-2 form-group text-center">
                    <button type="reset" class="btn resetbutton mt-3">BORRAR CAMPOS</button>
                    <button type="submit" id="submit" class="btn btn-primary mt-3">EDITAR USUARIO</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        //Recojo en un json el listado de los Email existentes para poder
        //hacer una validación que impida introducir un usuario ya introducido en la BBDD.
        //Este dniList será usado en el script que se carga a continuación.
        let emailList = {!! json_encode($emailList) !!};
    </script>
    <script src="{{ asset('js/usuarios/editar_usuario.js') }}"></script>
@endsection
