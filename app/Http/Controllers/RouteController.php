<?php

namespace App\Http\Controllers;

use App\Models\client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    /**
     * index permite mostrar el listado total de clientes enrutados
     * y el filtrado por distintos campos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->date;

        if ($searchValue == null) {
            $searchValue = date("Y-m-d");
        }
        $id_user = Auth::user()->id;
        $clients = DB::table('clients')
            ->select('id', 'cif', 'name', 'zip', 'address', 'town', 'province', 'email', 'phone', 'visit_date', 'longitude', 'latitude', 'owner', 'updated_at')
            ->where('visit_date', 'LIKE', "%$searchValue%")
            ->where('id_user', 'LIKE', "%$id_user%")
            ->orderBy('name', 'asc')
            ->paginate(5);

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

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
     * La función edit retornará al formulario de edición del día de visita al cliente.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = client::findOrFail($id);

        return view('rutero/editar_dia', ['client' => $client]);
    }

    /**
     * update me permite guardar en la BBDD el el día de visita editado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = client::findOrFail($id);

        $client->visit_date = $request->input('visit_date');
        $client->save();

        return redirect()->route('cliente_index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

    }
}
