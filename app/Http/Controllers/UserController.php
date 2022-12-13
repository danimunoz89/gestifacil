<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * index permite mostrar el listado total de usuarios
     * y el filtrado por distintos campos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $searchDNI = $request->dni;
        $searchName = $request->name;
        $searchLastname = $request->lastname;
        $searchPhone = $request->phone;
        $searchEmail = $request->email;

        $id_user = Auth::user()->id;

        if ($id_user == 1) {
            $users = DB::table('users')
            ->select('id', 'dni', 'name', 'lastname', 'email', 'phone')
            ->where('dni', 'LIKE', '%' . $searchDNI . '%')
            ->where('name', 'LIKE', '%' . $searchName . '%')
            ->where('lastname', 'LIKE', '%' . $searchLastname . '%')
            ->where('phone', 'LIKE', '%' . $searchPhone . '%')
            ->where('email', 'LIKE', '%' . $searchEmail . '%')
            ->orderBy('name', 'asc')
            ->paginate(5);
        }
        else {
            $users = DB::table('users')
            ->select('id', 'dni', 'name', 'lastname', 'email', 'phone')
            ->where('id', '!=', '1')
            ->where('dni', 'LIKE', '%' . $searchDNI . '%')
            ->where('name', 'LIKE', '%' . $searchName . '%')
            ->where('lastname', 'LIKE', '%' . $searchLastname . '%')
            ->where('phone', 'LIKE', '%' . $searchPhone . '%')
            ->where('email', 'LIKE', '%' . $searchEmail . '%')
            ->orderBy('name', 'asc')
            ->paginate(5);
        }


        return view('usuarios/index', ['users' => $users, 'searchDNI' => $searchDNI, 'searchName' => $searchName, 'searchLastname' => $searchLastname, 'searchPhone' => $searchPhone, 'searchEmail' => $searchEmail]);
    }

    /**
     * La función create retornará al formulario de creación de usuarios.
     * Con ella también retorno el listado de DNI y Email que me permitirá
     * validar si el usuario introducido está o no en la BBDD.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = DB::table('roles')
            ->select('id', 'name');
        $roles = $roles->get();

        $users = DB::table('users')
            ->select('dni', 'email');
        $users = $users->get();

        $dniList = array();
        $emailList = array();

        foreach ($users as $user) {
            array_push($dniList, $user->dni);
            array_push($emailList, $user->email);
        }

        return view('usuarios/crear_usuario', ['roles' => $roles, 'dniList' => $dniList, 'emailList' => $emailList]);
    }

    /**
     * store me permite guardar en la BBDD el usuario creado, previa validación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = $request->validate(
            [
                'name' => 'required|max:100',
                'lastname' => 'required|max:100',
                'dni' => ['required', 'regex:/^[0-9\-]{7,8}[A-z]?$/', 'unique:users,dni'],
                'email' => ['required', 'regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', 'unique:users,email'],
                'password' => 'required|max:16',
                'passrepeat' => 'required|max:16|same:password',
                'phone' => ['required', 'regex:/^(6|8|9)[0-9]{8}$/'],
                'role' => 'required|in:1,2',
            ],
            [
                'in' => 'Selecciona un rol para el usuario',
                'required' => 'El campo :attribute no puede estar vacio',
                'max' => 'El campo :attribute tiene mas caracteres de los permitidos',
                'unique' => 'El campo ::attribute está ya incluido en la BBDD',
                'regex' => 'El campo :attribute no tiene el formato correcto.',
                'exist' => 'Este :attribute ya está en uso',
                'same' => 'Las contraseñas no coinciden'
            ]
        );

        if ($validate) {
            $user = new User();
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->dni = $request->dni;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->assignRole($request->role);

            return redirect()->route('usuario_index');
        }
    }

    /**
     * La función edit retornará al formulario de edición de usuarios.
     * Con ella también retorno el listado de email que me permitirá
     * validar si el usuario introducido está o no en la BBDD.
     * 
     * El listado de email no incluye todos, incluye todos menos el que se va
     * a editar para evitar que, si no queremos cambiar el email, salte un error que
     * diga que el usuario ya está en la BBDD.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('name', 'model_id', 'role_id')
            ->where('model_id', 'LIKE', '%' . $id . '%');

        $roles = $roles->get();

        $user = user::findOrFail($id);

        $lists = DB::table('users')
            ->select('email');
        $lists = $lists->get();

        $emailList = array();

        foreach ($lists as $list) {
            if ($list->email != $user->email) {
                array_push($emailList, $list->email);
            }
        }

        return view('usuarios/editar_usuario', ['user' => $user, 'roles' => $roles, 'emailList' => $emailList]);
    }

    /**
     * update me permite guardar en la BBDD el usuario editado, previa validación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = user::findOrFail($id);

        $validate = $request->validate(
            [
                'name' => 'required|max:100',
                'lastname' => 'required|max:100',
                'dni' => ['required', 'regex:/^[0-9\-]{7,8}[A-z]?$/', 'unique:users,dni, ' . $id . ''],
                'email' => ['required', 'regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', 'unique:users,email, ' . $id . ''],
                'password' => 'required|max:16',
                'passrepeat' => 'required|max:16|same:password',
                'phone' => ['required', 'regex:/^(6|8|9)[0-9]{8}$/'],
                'role' => 'required|in:1,2',
            ],
            [
                'in' => 'Selecciona un rol para el usuario',
                'required' => 'El campo :attribute no puede estar vacio',
                'max' => 'El campo :attribute tiene mas caracteres de los permitidos',
                'unique' => 'El campo ::attribute está ya incluido en la BBDD',
                'regex' => 'El campo :attribute no tiene el formato correcto.',
                'same' => 'Las contraseñas no coinciden'
            ]
        );

        if ($validate) {
            $user->name = $request->input('name');
            $user->lastname = $request->input('lastname');
            $user->dni = $request->input('dni');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            $role = $request->input('role');

            DB::update('update model_has_roles set role_id = ? where model_id = ?', [$role, $id]);

            return redirect()->route('usuario_index');
        }
    }

    /**
     * destroy elimina un usuario de la BBDD.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = user::findOrFail($id);

        $user->delete();

        return redirect()->route('usuario_index');
    }
}
