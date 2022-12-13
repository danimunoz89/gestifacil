<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * index permite mostrar el listado total de clientes
     * y el filtrado por distintos campos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = user::all();

        $searchClient = $request->name;
        $searchTown = $request->town;
        $searchPhone = $request->phone;
        $searchUser = $request->userid;

        if ($searchUser == "") {
            $clients = DB::table('clients')
            ->select('id', 'cif', 'name', 'zip', 'address', 'town', 'province', 'email', 'phone', 'owner', 'updated_at')
            ->where('name', 'LIKE', '%' . $searchClient . '%')
            ->where('town', 'LIKE', '%' . $searchTown . '%')
            ->where('phone', 'LIKE', '%' . $searchPhone . '%')
            ->orderBy('name', 'asc')
            ->paginate(5);
        }
        else {
            $clients = DB::table('clients')
            ->select('id', 'cif', 'name', 'zip', 'address', 'town', 'province', 'email', 'phone', 'owner', 'updated_at')
            ->where('name', 'LIKE', '%' . $searchClient . '%')
            ->where('town', 'LIKE', '%' . $searchTown . '%')
            ->where('phone', 'LIKE', '%' . $searchPhone . '%')
            ->where('id_user', 'LIKE', '%' . $searchUser . '%')
            ->orderBy('name', 'asc')
            ->paginate(5);
        }

        return view('clientes/index', ['users' => $users, 'clients' => $clients, 'searchClient' => $searchClient, 'searchTown' => $searchTown, 'searchPhone' => $searchPhone]);
    }

    /**
     * La función create retornará al formulario de creación de clientes.
     * Con ella también retorno el listado de CIFs que me permitirá
     * validar si el cliente introducido está o no en la BBDD.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = user::all();

        $clients = DB::table('clients')
            ->select('cif');

        $clients = $clients->get();

        $cifList = array();

        foreach ($clients as $client) {
            array_push($cifList, $client->cif);
        }

        return view('clientes/crear_cliente', ['users' => $users, 'cifList' => $cifList]);
    }

    /**
     * store me permite guardar en la BBDD el cliente creado, previa validación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'iduser' => 'required|not_in:0',
                'name' => 'required|max:100',
                'cif' => ['required', 'regex:/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/', 'unique:clients,cif'],
                'email' => ['required', 'max:100', 'regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/'],
                'phone' => ['required', 'regex:/^(6|8|9)[0-9]{8}$/'],
                'zip' => 'required|max:5',
                'address' => 'required|max:255',
                'town' => 'required|max:255',
                'province' => 'required|max:255',
                'owner' => 'required|max:100'
            ],
            [
                'not_in' => 'Selecciona un comercial para el cliente',
                'required' => 'El campo :attribute no puede estar vacio',
                'max' => 'El campo :attribute tiene mas caracteres de los permitidos',
                'unique' => 'El campo ::attribute está ya incluido en la BBDD',
                'regex' => 'El campo :attribute no tiene el formato correcto.',
            ]
        );

        if ($validate) {
            $id_user = request()->iduser;
            $name = request()->name;
            $cif = request()->cif;
            $phone = request()->phone;
            $email = request()->email;
            $zip = request()->zip;
            $address = request()->address;
            $town = request()->town;
            $province = request()->province;
            $longitude = request()->longitude;
            $latitude = request()->latitude;
            $owner = request()->owner;
            $visit_date = request()->visit_date;

            $client = new client();
            $client->id_user = $id_user;
            $client->name = $name;
            $client->cif = $cif;
            $client->phone = $phone;
            $client->email = $email;
            $client->zip = $zip;
            $client->address = $address;
            $client->town = $town;
            $client->province = $province;
            $client->longitude = $longitude;
            $client->latitude = $latitude;
            $client->owner = $owner;
            $client->visit_date = $visit_date;
            $client->save();

            return redirect()->route('cliente_index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(client $client)
    {
        //
    }

    /**
     * La función edit retornará al formulario de edición de clientes.
     * Con ella también retorno el listado de CIFs que me permitirá
     * validar si el cliente introducido está o no en la BBDD.
     * 
     * El listado de CIFs no incluye todos, incluye todos menos el que se va
     * a editar para evitar que, si no queremos cambiar el CIF, salte un error que
     * diga que el cliente ya está en la BBDD (En el formulario el CIF es no editable
     * ya que es algo que no se cambia, como ocurre con los nº de DNI).
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = user::all();

        $client = client::findOrFail($id);

        $lists = DB::table('clients')
            ->select('cif');

        $lists = $lists->get();

        $cifList = array();

        foreach ($lists as $list) {
            if ($list->cif != $client->cif) {
                array_push($cifList, $list->cif);
            }
        }

        return view('clientes/editar_cliente', ['client' => $client, 'users' => $users, 'cifList' => $cifList]);
    }

    /**
     * update me permite guardar en la BBDD el cliente editado, previa validación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $client = client::findOrFail($id);

        $validate = $request->validate(
            [
                'iduser' => 'required|not_in:0',
                'name' => 'required|max:100',
                'cif' => ['required', 'regex:/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/', 'unique:clients,cif, ' . $id . ''],
                'email' => ['required', 'max:100', 'regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/'],
                'phone' => ['required', 'regex:/^(6|8|9)[0-9]{8}$/'],
                'zip' => 'required|max:5',
                'address' => 'required|max:255',
                'town' => 'required|max:255',
                'province' => 'required|max:255',
                'owner' => 'required|max:100'
            ],
            [
                'not_in' => 'Selecciona un comercial para el cliente',
                'unique' => 'El campo ::attribute está ya incluido en la BBDD',
                'max' => 'El campo :attribute tiene mas caracteres de los permitidos',
                'required' => 'El campo :attribute no puede estar vacio',
                'regex' => 'El campo :attribute no tiene el formato correcto.',
            ]
        );

        if ($validate) {
            $client->id_user = $request->input('iduser');
            $client->name = $request->input('name');
            $client->cif = $request->input('cif');
            $client->phone = $request->input('phone');
            $client->email = $request->input('email');
            $client->zip = $request->input('zip');
            $client->address = $request->input('address');
            $client->town = $request->input('town');
            $client->province = $request->input('province');
            $client->longitude = $request->input('longitude');
            $client->latitude = $request->input('latitude');
            $client->owner = $request->input('owner');
            $client->visit_date = $request->input('visit_date');
            $client->save();

            return redirect()->route('cliente_index');
        }
    }

    /**
     * destroy elimina un cliente de la BBDD.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $client = client::findOrFail($id);

        $client->delete();

        return redirect()->route('cliente_index');
    }
}
