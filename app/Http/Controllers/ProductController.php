<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * index permite mostrar el listado total de productos
     * y el filtrado por distintos campos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchCategory = null;

        if ($request->category != 0) {
            $searchCategory = $request->category;
        }

        $searchName = $request->name;
        $searchProducer = $request->producer;
        $searchFormat = $request->format;

        $categories = category::all();

        $products = DB::table('products')
            ->join('categories', 'products.id_category', '=', 'categories.id')
            ->select('products.id as id', 'categories.name as namecategory', 'products.name as name', 'products.description as description', 'producer', 'format', 'unit_price', 'products.image as image', 'stock', 'products.updated_at')
            ->where('categories.id', 'LIKE', '%' . $searchCategory . '%')
            ->where('products.name', 'LIKE', '%' . $searchName . '%')
            ->where('producer', 'LIKE', '%' . $searchProducer . '%')
            ->where('format', 'LIKE', '%' . $searchFormat . '%')
            ->orderBy('products.name', 'asc')
            ->paginate(5);

        return view('productos/index', ['products' => $products, 'categories' => $categories, 'searchName' => $searchName, 'searchCategory' => $searchCategory, 'searchProducer' => $searchProducer, 'searchFormat' => $searchFormat]);
    }

    /**
     * La función create retornará al formulario de creación de productos.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = category::all();

        return view('productos/crear_producto', ['categories' => $categories]);
    }

    /**
     * store me permite guardar en la BBDD el producto creado, previa validación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'idcategory' => 'required|not_in:0',
                'name' => 'required|max:100',
                'producer' => 'required|max:100',
                'description' => 'max:255',
                'format' => 'required|max:100',
                'unitprice' => 'numeric:10',
                'image' => 'required|mimes:jpeg,png,jpg|max:2000'
            ],
            [
                'not_in' => 'Selecciona una categoría para el producto',
                'required' => 'El campo :attribute no puede estar vacio',
                'numeric' => 'El campo :attribute tiene que ser numérico',
                'max' => 'El campo :attribute tiene mas caracteres de los permitidos',
                'exist' => 'Este :attribute ya está en uso',
                'mimes' => 'El campo :attribute está vacio o no tiene el formato correcto (jpeg,png,jpg).',
                'size' => "El archivo es mayor de 2000kb (2MB)",
            ]
        );

        if ($validate) {
            $id_category = request()->idcategory;
            $name = request()->name;
            $description = request()->description;
            $producer = request()->producer;
            $format = request()->format;
            $unit_price = request()->unitprice;
            $stock = request()->stock;

            if ($stock == NULL) {
                $stock = "0";
            }

            $image = request()->file('image');

            $productImage = null;

            if ($image) {
                $destinationPath = "img/products/";
                $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $productImage);
            }

            $product = new product();
            $product->id_category = $id_category;
            $product->name = $name;
            $product->description = $description;
            $product->producer = $producer;
            $product->format = $format;
            $product->unit_price = $unit_price;
            $product->stock = $stock;
            $product->image = $productImage;

            $product->save();

            return redirect()->route('producto_index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * La función edit retornará al formulario de edición de productos.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = product::findOrFail($id);

        $categories = category::all();

        return view('productos/editar_producto', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * update me permite guardar en la BBDD el producto editado, previa validación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = product::findOrFail($id);

        $validate = $request->validate(
            [
                'idcategory' => 'required|not_in:0',
                'name' => 'required|max:100',
                'producer' => 'required|max:100',
                'description' => 'max:255',
                'format' => 'required|max:100',
                'unitprice' => 'numeric:10',
                'image' => 'mimes:jpeg,png,jpg|max:2000'
            ],
            [
                'not_in' => 'Selecciona una categoría para el producto',
                'required' => 'El campo :attribute no puede estar vacio',
                'numeric' => 'El campo :attribute tiene que ser numérico',
                'max' => 'El campo :attribute tiene mas caracteres de los permitidos',
                'exist' => 'Este :attribute ya está en uso',
                'mimes' => 'El campo :attribute está vacio o no tiene el formato correcto (jpeg,png,jpg)',
                'size' => "El archivo es mayor de 2000kb (2MB)",
            ]
        );

        if ($validate) {
            $oldpath = $request->input('current_image');

            $product->id_category = $request->input('idcategory');
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->producer = $request->input('producer');
            $product->format = $request->input('format');
            $product->unit_price = $request->input('unitprice');

            $stock = $request->input('stock');
            if ($stock == NULL) {
                $stock = "0";
            }

            $product->stock = $stock;

            $image = request()->file('image');

            if (request()->file('image') != "") {
                $destination = 'img/products/' . $oldpath;

                if ($destination != "img/products/") {
                    File::delete($destination);
                }

                $destinationPath = "img/products/";
                $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $productImage);

                $product->image =  $productImage;
            }

            $product->save();

            return redirect()->route('producto_index');
        }
    }

    /**
     * destroy elimina un producto de la BBDD.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = product::findOrFail($id);

        $oldpath = $product->image;
        $destination = 'img/products/' . $oldpath;
        File::delete($destination);

        $product->delete();

        return redirect()->route('producto_index');
    }
}
