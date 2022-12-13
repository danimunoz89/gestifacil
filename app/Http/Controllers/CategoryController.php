<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * index permite mostrar el listado total de categorías
     * y el filtrado por distintos campos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchValue = null;

        if ($request->category != 0) {
            $searchValue = $request->category;
        }

        $categoriesSelect = category::all();

        $categories = DB::table('categories')
            ->select('id', 'name', 'image')
            ->where('id', 'LIKE', '%' . $searchValue . '%')
            ->orderBy('name', 'asc')
            ->paginate(5);

        return view('categorias/index', ['categoriesSelect' => $categoriesSelect, 'categories' => $categories, 'searchValue' => $searchValue]);
    }

    /**
     * La función create retornará al formulario de creación de categorías.
     * Con ella también retorno el listado de categorías que me permitirá
     * validar si la categoría introducida está o no en la BBDD.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('categories')
            ->select('name');

        $categories = $categories->get();

        $categoriesList = array();

        foreach ($categories as $category) {
            array_push($categoriesList, $category->name);
        }

        return view('categorias/crear_categoria', ['categoriesList' => $categoriesList]);
    }

    /**
     * store me permite guardar en la BBDD la categoría creada, previa validación.
     * También guardará en la carpeta public/img/categories la imagen de la categoría
     * insertada por el usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'name' => ['required', 'max:100', 'unique:categories,name'],
                'image' => 'required|mimes:jpeg,png,jpg|max:2000'
            ],
            [
                'required' => 'El campo :attribute no puede estar vacio',
                'max' => 'El campo :attribute tiene mas caracteres de los permitidos',
                'unique' => 'El campo ::attribute está ya incluido en la BBDD',
                'mimes' => 'El campo :attribute está vacio o no tiene el formato correcto (jpeg,png,jpg)',
                'size' => "El archivo es mayor de 2000kb (2MB)",
            ]
        );
        if ($validate) {
            $name = request()->name;
            $image = request()->file('image');

            $categorieImage = null;

            if ($image) {
                $destinationPath = "img/categories/";
                $categorieImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $categorieImage);
            }

            $category = new category();
            $category->name = $name;
            $category->image = $categorieImage;
            $category->save();

            return redirect()->route('categoria_index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * La función edit retornará al formulario de edición de categorías.
     * Con ella también retorno el listado de categorías que me permitirá
     * validar si la categoría introducida está o no en la BBDD.
     * 
     * El listado de categorías no incluye todas, incluye todas menos la que se va
     * a editar para evitar que, si no queremos cambiar el nombre, salte un error que
     * diga que la categoría ya está en la BBDD.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = category::findOrFail($id);

        $lists = DB::table('categories')
            ->select('name');

        $lists = $lists->get();

        $categoriesList = array();

        foreach ($lists as $list) {
            if ($list->name != $category->name) {
                array_push($categoriesList, $list->name);
            }
        }

        return view('categorias/editar_categoria', ['category' => $category, 'categoriesList' => $categoriesList]);
    }


    /**
     * update me permite guardar en la BBDD la categoría editada, previa validación.
     * También guardará en la carpeta public/img/categories la imagen de la categoría
     * insertada por el usuario. En caso que la categoría ya tuviera una imagen previa
     * esta será reemplazada por la nueva.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = category::findOrFail($id);

        $validate = $request->validate(
            [
                'name' => ['required', 'max:100', 'unique:categories,name, ' . $id . ''],
                'image' => 'mimes:jpeg,png,jpg|max:2000'
            ],
            [
                'required' => 'El campo :attribute no puede estar vacio',
                'max' => 'El campo :attribute tiene mas caracteres de los permitidos',
                'unique' => 'El campo ::attribute está ya incluido en la BBDD',
                'mimes' => 'El campo :attribute está vacio o no tiene el formato correcto (jpeg,png,jpg)',
                'size' => "El archivo es mayor de 2000kb (2MB)",
            ]
        );

        if ($validate) {

            $oldpath = $request->input('current_image');

            $category->name = $request->input('name');

            $image = request()->file('image');

            if (request()->file('image') != "") {
                $destination = 'img/categories/' . $oldpath;

                if ($destination != "img/categories/") {
                    File::delete($destination);
                }

                $destinationPath = "img/categories/";
                $categorieImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $categorieImage);

                $category->image =  $categorieImage;
            }

            $category->save();

            return redirect()->route('categoria_index');
        }
    }

    /**
     * destroy elimina una categoría de la BBDD. Al eliminar la categoría
     * también se elimina la foto asociada a ella permitiendo
     * reducir el espacio en los HDD.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = category::findOrFail($id);

        $oldpath = $category->image;
        $destination = 'img/categories/' . $oldpath;
        File::delete($destination);

        $category->delete();

        return redirect()->route('categoria_index');
    }
}
