<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('pages.dashboard.index'))->name('dashboard');

Route::prefix('productos')->name('productos.')->group(function () {
    Route::get('/', fn () => view('pages.productos.listado'))->name('index');
    Route::get('/crear', fn () => view('pages.productos.crear'))->name('create');
    Route::get('/{producto}/editar', fn ($producto) => view('pages.productos.editar', ['productoId' => $producto]))->name('edit');
    Route::get('/{producto}', fn ($producto) => view('pages.productos.detalle', ['producto' => $producto]))->name('show');
});

Route::prefix('ventas')->name('ventas.')->group(function () {
    Route::get('/', fn () => view('pages.ventas.listado'))->name('index');
    Route::get('/crear', fn () => view('pages.ventas.crear'))->name('create');
    Route::get('/{venta}', fn ($venta) => view('pages.ventas.detalle', ['venta' => $venta]))->name('show');
});

Route::prefix('clientes')->name('clientes.')->group(function () {
    Route::get('/', fn () => view('pages.clientes.listado'))->name('index');
    Route::get('/crear', fn () => view('pages.clientes.crear'))->name('create');
    Route::get('/{cliente}', fn ($cliente) => view('pages.clientes.detalle', ['cliente' => $cliente]))->name('show');
});

Route::prefix('usuarios')->name('usuarios.')->group(function () {
    Route::get('/', fn () => view('pages.usuarios.listado'))->name('index');
    Route::get('/crear', fn () => view('pages.usuarios.editar'))->name('create');
    Route::get('/{usuario}/editar', fn ($usuario) => view('pages.usuarios.editar', ['usuarioId' => $usuario]))->name('edit');
});

Route::get('/pedidos', fn () => view('pages.pedidos.listado'))->name('pedidos');
Route::get('/inventario', fn () => view('pages.inventario.listado'))->name('inventario');
Route::get('/reportes', fn () => view('pages.reportes.index'))->name('reportes');
Route::get('/configuracion', fn () => view('pages.configuracion.index'))->name('configuracion');

Route::get('/login', fn () => view('pages.auth.login'))->name('login');
Route::get('/404', fn () => view('pages.not-found'))->name('not-found');