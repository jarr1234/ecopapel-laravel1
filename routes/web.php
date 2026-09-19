<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\AdminController;

Route::get('/', [InicioController::class, 'index'])
    ->name('inicio');

Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/registro', [AuthController::class, 'registroForm'])
    ->name('registro');

Route::post('/registro', [AuthController::class, 'registro'])
    ->name('registro.post');

Route::get('/verificar', [AuthController::class, 'verificarForm'])
    ->name('verificar');

Route::post('/verificar', [AuthController::class, 'verificar'])
    ->name('verificar.post');

Route::get('/productos', [ProductoController::class, 'index'])
    ->name('productos');

Route::get('/carrito', [CarritoController::class, 'index'])
    ->name('carrito');

Route::post('/carrito', [CarritoController::class, 'agregar'])
    ->name('carrito.agregar');

Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])
    ->name('carrito.eliminar');

Route::delete('/carrito', [CarritoController::class, 'vaciar'])
    ->name('carrito.vaciar');

Route::get('/comprar', [CompraController::class, 'form'])
    ->name('comprar');

Route::post('/comprar', [CompraController::class, 'procesar'])
    ->name('comprar.procesar');

Route::get('/compra/comprobante/{id}', [CompraController::class, 'comprobante'])
    ->name('compra.comprobante');

Route::prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'index'])
        ->name('admin');

    Route::get('/productos', [AdminController::class, 'productos'])
        ->name('admin.productos');

    Route::get('/ver-productos', [AdminController::class, 'verProductos'])
        ->name('admin.productos.ver');

    Route::post('/productos', [AdminController::class, 'guardarProducto'])
        ->name('admin.productos.guardar');

    Route::get('/productos/{id}/editar', [AdminController::class, 'editarProducto'])
        ->name('admin.productos.editar');

    Route::put('/productos/{id}', [AdminController::class, 'actualizarProducto'])
        ->name('admin.productos.actualizar');

    Route::delete('/productos/{id}', [AdminController::class, 'eliminarProducto'])
        ->name('admin.productos.eliminar');

    Route::get('/usuarios', [AdminController::class, 'usuarios'])
        ->name('admin.usuarios');

    Route::post('/usuarios', [AdminController::class, 'guardarUsuario'])
        ->name('admin.usuarios.guardar');

    Route::delete('/usuarios/{id}', [AdminController::class, 'eliminarUsuario'])
        ->name('admin.usuarios.eliminar');

    Route::get('/categorias', [AdminController::class, 'categorias'])
        ->name('admin.categorias');

    Route::post('/categorias', [AdminController::class, 'guardarCategoria'])
        ->name('admin.categorias.guardar');

    Route::delete('/categorias/{id}', [AdminController::class, 'eliminarCategoria'])
        ->name('admin.categorias.eliminar');

    Route::get('/ventas', [AdminController::class, 'ventas'])
        ->name('admin.ventas');

    Route::patch('/ventas/{id}', [AdminController::class, 'entregar'])
        ->name('admin.ventas.entregar');

    Route::get('/cortes', [AdminController::class, 'cortes'])
        ->name('admin.cortes');
});