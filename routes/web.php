<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginAccessController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesorderController;
use App\Http\Controllers\Enlaces;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

//Ventana principal INICIO
Route::get('/', [LoginAccessController::class, 'login'])->name('inicio_login');
Route::post('/login-user', [LoginAccessController::class, 'loginCheck'])->name('login-user');
Route::get('/logout', [LoginAccessController::class, 'logout'])->name('usuario_desconexion');

//Ventana principal Rutero General (con el listado de tablas)
Route::get('/rutero-total', [RouteController::class, 'index'])->middleware('can:ver_rutero')->name('rutero_index');
//Rutas vinculadas a la edición de fecha visita
Route::get('/rutero/editar_dia/{id}', [RouteController::class, 'edit'])->middleware('can:editar_dia')->name('dia_editar');
Route::post('/rutero/editar_dia/{id}', [RouteController::class, 'update'])->name('dia_actualizar');

//Ventana principal usuarios (con el listado de tablas)
Route::get('/usuarios', [UserController::class, 'index'])->middleware('can:listar_usuarios')->name('usuario_index');
//Rutas vinculadas a la creación de usuarios
Route::get('/usuarios/crear_usuario', [UserController::class, 'create'])->middleware('can:crear_usuarios')->name('usuario_crear');
Route::post('/usuarios/crear_usuario', [UserController::class, 'store'])->name('usuario_guardar');
//Rutas vinculadas a la edición de usuarios
Route::get('/usuarios/editar_usuario/{id}', [UserController::class, 'edit'])->middleware('can:editar_usuarios')->name('usuario_editar');
Route::post('/usuarios/editar_usuario/{id}', [UserController::class, 'update'])->name('usuario_actualizar');
//Ruta vinculada al borrado de usuarios
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->middleware('can:eliminar_usuarios')->name('usuario_eliminar');

//Ventana principal clientes (con el listado de tablas)
Route::get('/clientes', [ClientController::class, 'index'])->middleware('can:listar_clientes')->name('cliente_index');
//Rutas vinculadas a la creación de clientes
Route::get('/clientes/crear_cliente', [ClientController::class, 'create'])->middleware('can:crear_clientes')->name('cliente_crear');
Route::post('/clientes/crear_cliente', [ClientController::class, 'store'])->name('cliente_guardar');
//Rutas vinculadas a la edición de clientes
Route::get('/clientes/editar_cliente/{id}', [ClientController::class, 'edit'])->middleware('can:editar_clientes')->name('cliente_editar');
Route::post('/clientes/editar_cliente/{id}', [ClientController::class, 'update'])->name('cliente_actualizar');
//Ruta vinculada al borrado de clientes
Route::delete('/clientes/{id}', [ClientController::class, 'destroy'])->middleware('can:eliminar_clientes')->name('cliente_eliminar');

//Ventana principal categorias (con el listado de tablas)
Route::get('/categorias', [CategoryController::class, 'index'])->middleware('can:listar_categorias')->name('categoria_index');
//Rutas vinculadas a la creación de categorias
Route::get('/categorias/crear_categoria', [CategoryController::class, 'create'])->middleware('can:crear_categorias')->name('categoria_crear');
Route::post('/categorias/crear_categoria', [CategoryController::class, 'store'])->name('categoria_guardar');
//Rutas vinculadas a la edición de categorias
Route::get('/categorias/editar_categoria/{id}', [CategoryController::class, 'edit'])->middleware('can:editar_categorias')->name('categoria_editar');
Route::post('/categorias/editar_categoria/{id}', [CategoryController::class, 'update'])->name('categoria_actualizar');
//Ruta vinculada al borrado de categorias
Route::delete('/categorias/{id}', [CategoryController::class, 'destroy'])->middleware('can:eliminarcategorias')->name('categoria_eliminar');

//Ventana principal productos (con el listado de tablas)
Route::get('/productos', [ProductController::class, 'index'])->middleware('can:listar_productos')->name('producto_index');
//Rutas vinculadas a la creación de productos
Route::get('/productos/crear_producto', [ProductController::class, 'create'])->middleware('can:crear_productos')->name('producto_crear');
Route::post('/productos/crear_producto', [ProductController::class, 'store'])->name('producto_guardar');
//Rutas vinculadas a la edición de productos
Route::get('/productos/editar_producto/{id}', [ProductController::class, 'edit'])->middleware('can:editar_productos')->name('producto_editar');
Route::post('/productos/editar_producto/{id}', [ProductController::class, 'update'])->name('producto_actualizar');
//Ruta vinculada al borrado de productos
Route::delete('/productos/{id}', [ProductController::class, 'destroy'])->middleware('can:eliminar_productos')->name('producto_eliminar');

//Ventana principal pedidos (con el listado de tablas)
Route::get('/pedidos', [SalesorderController::class, 'index'])->middleware('can:listar_pedidos')->name('pedidos_index');
//Rutas vinculadas a la creación de pedidos
Route::get('/pedidos/crear_pedido', [SalesorderController::class, 'create'])->middleware('can:crear_pedidos')->name('pedido_crear');
Route::post('/pedidos/crear_pedido', [SalesorderController::class, 'store'])->name('pedido_guardar');
//Ruta vinculada al borrado de pedidos
Route::delete('/pedidos/{id}', [SalesorderController::class, 'destroy'])->middleware('can:eliminar_pedidos')->name('pedido_eliminar');
//Rutas vinculadas a la edición de notas
Route::get('/pedidos/editar_nota/{id}', [SalesorderController::class, 'edit_note'])->middleware('can:editar_notapedidos')->name('nota_editar');
Route::post('/pedidos/editar_nota/{id}', [SalesorderController::class, 'update_note'])->name('nota_actualizar');
//Ruta para generar PDF Pedidos
Route::get('/pedidos/{id_client}', [SalesorderController::class, 'generatePDF'])->middleware('can:pdf_pedidos')->name('pdf_generar');

//Ventana Sobre Nosotros
Route::get('/sobrenosotros', [Enlaces::class, 'aboutUs'])->name('enlaces_sobrenosotros');
//Ventana Politica Privacidad
Route::get('/politicaprivacidad', [Enlaces::class, 'privacyPolicy'])->name('enlaces_politicaprivacidad');
//Ventana Mapa Web
Route::get('/mapaweb', [Enlaces::class, 'webMap'])->middleware('can:mapa_web')->name('enlaces_mapaweb');
