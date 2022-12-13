<?php

namespace App\Http\Controllers;

use App\Models\salesorder;
use App\Models\client;
use App\Models\detail;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;

class SalesorderController extends Controller
{
    /**
     * index permite mostrar el listado total de pedidos
     * y el filtrado por distintos campos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchId = $request->id;
        $searchName = $request->name;
        $searchDate = $request->date;

        $orders = DB::table('salesorders')
            ->join('clients', 'salesorders.id_client', '=', 'clients.id')
            ->select('salesorders.id as id', 'clients.name as client', 'order_date', 'total_price', 'note')
            ->where('salesorders.id', 'LIKE', "%$searchId%")
            ->where('clients.name', 'LIKE', "%$searchName%")
            ->where('order_date', 'LIKE', "%$searchDate%")
            ->orderBy('id', 'asc')
            ->paginate(5);

        $details = detail::all();

        return view('pedidos/index', ['orders' => $orders, 'searchName' => $searchName, 'searchId' => $searchId, 'searchDate' => $searchDate, 'details' => $details]);
    }

    /**
     * La función create retornará al formulario de creación de pedidos.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_user = Auth::user()->id;
        $clients = DB::table('clients')
            ->select('id', 'cif', 'name', 'zip', 'address', 'town', 'province', 'email', 'phone', 'visit_date', 'longitude', 'latitude', 'owner', 'updated_at')
            ->where('id_user', 'LIKE', "%$id_user%")->get();

        $products = product::all();

        $products = DB::table('products')
            ->select('name', 'id', 'unit_price')
            ->where('stock', '=', '1')->get();

        return view('pedidos/crear_pedido', ['products' => $products, 'clients' => $clients]);
    }

    /**
     * store me permite guardar en la BBDD tanto el pedido creado
     * como el detalle del pedido. Los detalles serán guardados en la tabla details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_client = request()->client;
        $order_date = request()->order_date;
        $note = request()->note;
        $id_products = request()->product;
        $prices = request()->price;
        $quantities = request()->quantity;

        $total_price = 0;

        $salesorder = new salesorder();
        $salesorder->id_client = $id_client;
        $salesorder->order_date = $order_date;
        $salesorder->note = $note;
        for ($i = 0; $i < count($id_products); $i++) {
            $total_price = $total_price + ($prices[$i] * $quantities[$i]);
        }

        $salesorder->total_price = $total_price;
        $salesorder->save();

        $order_id = DB::table('salesorders')
            ->max('id');

        for ($i = 0; $i < count($id_products); $i++) {
            $id_product = Str::of($id_products[$i])->explode('/');

            $details = new detail();

            $details->id_order = $order_id;
            $details->name_product = $id_product[0];
            $details->id_product = $id_product[2];
            $details->unit_price = $prices[$i];
            $details->quantity = $quantities[$i];

            $details->save();
        }

        return redirect()->route('pedidos_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\salesorder  $salesorder
     * @return \Illuminate\Http\Response
     */
    public function show(salesorder $salesorder)
    {
        //
    }

    /**
     * La función edit retornará al formulario de edición de la nota de un pedido.
     *
     * @param  \App\Models\salesorder  $salesorder
     * @return \Illuminate\Http\Response
     */
    public function edit_note($id)
    {
        $salesorder = DB::table('salesorders')
            ->join('clients', 'salesorders.id_client', '=', 'clients.id')
            ->select('salesorders.id as id', 'clients.name as client', 'order_date', 'total_price', 'note')
            ->where('salesorders.id', 'LIKE', "%$id%")
            ->get();

        return view('pedidos/editar_nota', ['salesorder' => $salesorder]);
    }

    /**
     * update me permite guardar en la BBDD la nota de un pedido editada, previa validación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\salesorder  $salesorder
     * @return \Illuminate\Http\Response
     */
    public function update_note(Request $request, $id)
    {
        $salesorder = salesorder::findOrFail($id);

        $validate = $request->validate(
            [
                'note' => 'max:255',
            ],
            [
                'max' => 'El campo :attribute tiene mas caracteres de los permitidos',
            ]
        );

        if ($validate) {
            $salesorder->note = $request->input('note');
            $salesorder->save();

            return redirect()->route('pedidos_index');
        }
    }

    /**
     * destroy elimina un pedido de la BBDD.
     *
     * @param  \App\Models\salesorder  $salesorder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salesorder = salesorder::findOrFail($id);

        $salesorder->delete();

        return redirect()->route('pedidos_index');
    }

    /**
     * Con generatePDF puedo generar PDFs asociados a un pedido en concreto.
     * Primero obtengo de las tablas la información que quiero que se muestre en el PDF.
     * 
     * A continuación inicializo un objeto DOMpdf y establezco en las opciones que permita
     * recoger información de fuera ('isRemoteEnabled') ya que las fotos no las recoge del proyecto
     * de forma adecuada. El logo usado está alojado en un hosting de imágenes para poder usarlo en la
     * generación del PDF.
     * 
     * Después, en formato html, edito la estructura de lo que va a ser mi hoja detallesPedido.
     * 
     * Por último, paso ese html a los métodos propios de DOMpdf para establecer el formato, generar, descargar y visualizar el PDF
     * con la información deseada.
     *
     * @param  \App\Models\salesorder  $salesorder
     * @return \Illuminate\Http\Response
     */
    public function generatePDF($id)
    {

        $salesorder = DB::table('salesorders')
            ->join('clients', 'salesorders.id_client', '=', 'clients.id')
            ->select('salesorders.id as id', 'clients.name as client', 'order_date', 'total_price', 'note')
            ->where('salesorders.id', '=', '' . $id . '')->get();

        $details = DB::table('details')
            ->select('id_order', 'name_product', 'unit_price', 'quantity')
            ->where('id_order', '=', '' . $id . '')
            ->get();

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $pdf = new Dompdf($options);
        $html = ' 
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>DETALLES DEL PEDIDO ' . $salesorder[0]->id . '/' . $salesorder[0]->client . ' </title>
        </head>
        <style>
            body {
                color: #60727c;
                font-family: "Helvetica";
                margin: auto;
                margin-right: 250px;
                width: 50%;
            }

            .tablemain {
                text-align: center;
                width: auto;
                border-collapse: separate; 
                border-spacing: 2em;
            }

            .info{
                text-align: left;
            }

            .tablehead{
                font-weight: bold;
            }

            .nota {
                text-width: bold;
                text-align: justify;
            }
        </style>

        <body>
            <div>
                <table class="tablemain">
                    <tr>
                        <td colspan = 2>
                            <img src="https://i.ibb.co/w0S3nwx/logo2.jpg" style="width: 10rem;" />
                        </td>
                        <td class="info" colspan = 2>
                            Pedido Número: ' . $salesorder[0]->id  . ' <br/>
                            Creado: ' . $salesorder[0]->order_date . '<br/>
                            Cliente: ' . $salesorder[0]->client . '
                        </td>
                    </tr>

                    <tr class="tablehead">
                        <td>PRODUCTO</td>
                        <td>PRECIO</td>
                        <td>CANTIDAD</td>
                        <td>COSTE</td>
                    </tr>
        ';

        foreach ($details as $detail) {
            $html .= '
            <tr>
                <td>' . $detail->name_product . '</td>
                <td>' . round($detail->unit_price) . ' €</td>
                <td>' . $detail->quantity . ' uds.</td>
                <td>' . round(($detail->quantity * $detail->unit_price)) . ' €</td>
            </tr>';
        }

        $html .= '
                    <tr>
                        <td colspan=4>Total: ' . round($salesorder[0]->total_price) . ' €</td>
                    </tr>
                    <tr>
                        <td colspan=4>Total (IVA incl.): ' . round(($salesorder[0]->total_price * 1.21)) . ' €</td>
                    </tr>
                    <tr>
                        <td class="nota" colspan=4><strong>Nota:</strong> ' . $salesorder[0]->note . '</td>
                    </tr>
                </table>
            </div>
        </body>
        </html>';

        //Recojo el HTML que he generado arriba
        $pdf->loadHtml($html);

        //Configuro el formato de papel y la horientación
        $pdf->setPaper('A4', 'portrait');

        //Genero el fichero PDF
        $pdf->render();

        //Muestro el PDF generado en pantalla
        $pdf->stream("NºPedido".$salesorder[0]->id."_".$salesorder[0]->client."_".$salesorder[0]->order_date.".pdf");
    }
}
