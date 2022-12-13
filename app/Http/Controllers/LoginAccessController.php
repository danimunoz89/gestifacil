<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginAccessController extends Controller
{
    /**
     * login permite mostrar el formulario de acceso a la aplicación.
     * En caso de que el usuario ya esté logueado (Comprobado con Auth::check())
     * este será retornado a la página de rutas.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::check()) {

            $searchValue = $request->date;

            if ($searchValue == null) {
                $searchValue = date("Y-m-d");
            }

            $clients = DB::table('clients')
                ->select('id', 'cif', 'name', 'zip', 'address', 'town', 'province', 'email', 'phone', 'visit_date', 'longitude', 'latitude', 'owner', 'updated_at')
                ->where('visit_date', 'LIKE', "%$searchValue%")
                ->orderBy('name', 'asc')
                ->paginate(10);

            $longitudes = array();
            $latitudes = array();
            $names = array();

            foreach ($clients as $client) {
                array_push($longitudes, $client->longitude);
                array_push($latitudes, $client->latitude);
                array_push($names, $client->name);
            }

            return view('rutero/index_rutero', ['clients' => $clients, 'searchValue' => $searchValue, 'latitudes' => $latitudes, 'longitudes' => $longitudes, 'names' => $names]);
        }

        return view("inicio/login");
    }

    /**
     * loginCheck permite validar el acceso de un usuario a la aplicación mediante
     * la comprobación del email y la contraseña.
     * 
     * Mediante Auth::attempt checkeo que las credenciales coincidan con la de la BBDD.
     * 
     * En caso de estarlo, abrimos sesión y le asignamos un token (será distinto cada vez que se produzca un login, por seguridad).
     * A la sesión también le asigno el nombre del usuario para saber que el usuario está correctamente logueado y esa
     * sesión "es suya".
     * 
     * En caso que no exista match entre email y contraseña se mostrará al usuario un mensaje de error.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginCheck(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerateToken();
            $request->session()->put('name', Auth::user()->name);

            return redirect()->route('rutero_index');
        }
        return back()->withErrors(['error' => "Error al introducir las credenciales. Revísalo."]);
    }

    /**
     * logout permite desconectar al usuario de la aplicación con el método Auth::logout() borrando 
     * toda la información de la sesión iniciada por el usuario con su login.
     * 
     * Como método de seguridad, para asegurar un correcto cierre de sesión, invalido la sesión del usuario
     * y además regenero el token para evitar que siga vinculado a la sesión de X usuario.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view("inicio/login");
    }
}
